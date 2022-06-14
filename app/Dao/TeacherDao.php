<?php

namespace App\Dao;

use App\Contracts\Dao\TeacherDaoInterface;
use App\Models\Teacher;

class TeacherDao implements TeacherDaoInterface
{
    public function getTeachers()
    {
        return Teacher::paginate(5);
    }

    public function getTeacher($id)
    {
        return Teacher::findOrFail($id);
    }

    public function updateTeacherDeatils($teacher, $teacherData)
    {
        $teacher->detail()->update([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);

        return $teacher;
    }

    public function updateTeacherCourse($teacher, $courses)
    {
        $teacher->courses()->detach();
        $teacher->courses()->attach($courses);

        return $teacher;
    }

    public function createTeacherDeatils($teacher, $teacherData)
    {
        $teacher->detail()->create([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);

        return $teacher;
    }

    public function createTeacherCourse($teacher, $courses)
    {
        $teacher->courses()->attach($courses);

        return $teacher;
    }

    public function deleteTeacherCourse($teacher)
    {
        $teacher->courses()->detach();
    }

    public function deleteTeacherDetails($stuent)
    {
        $teacher->detail()->delete();
    }

    public function deleteTeacher($teacher)
    {
        $teacher->delete();
    }

    public function searchTeacher($request)
    {
        $teacher = Teacher::query()
            ->select('teacher.*', DB::raw('count(course_id) as total_courses'))
            ->leftJoin('teacher_course', 'teacher.id', '=', 'teacher_course.teacher_id')
            ->when($name, function ($q, $name) {
                $q->where('teacher_name', 'LIKE', '%' . $name . '%');
            })
            ->when($email, function ($q, $email) {
                $q->where('email', 'LIKE', '%' . $email . '%');
            })
            ->when($gender, function ($q, $gender) {
                $q->where('gender', $gender);
            })
            ->when($isActive, function ($q, $isActive) {
                $q->whereIn('is_active', $isActive);
            })
            ->groupBy('teacher.id')
            ->orderby('id')
            ->get();

        return $teacher;
    }

    public function profileEditTeacherDeatils($teacher, $teacherData)
    {
        $teacher->detail()->update([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);

        return $teacher;
    }

    public function profileEditTeacherCourse($teacher)
    {
        $teacher->courses()->detach();
        $teacher->courses()->attach($courses);

        return $teacher;
    }

}
