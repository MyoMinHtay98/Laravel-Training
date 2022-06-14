<?php

namespace App\Dao;

use App\Contracts\Dao\StudentDaoInterface;
use App\Models\Student;

class StudentDao implements StudentDaoInterface
{
    public function getStudents()
    {
        return Student::paginate(5);
    }

    public function getStudent($id)
    {
        return Student::findOrFail($id);
    }

    public function updateStudentDeatils($student, $studentData)
    {
        $student->detail()->update([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);

        return $student;
    }

    public function updateStudentCourse($student, $courses)
    {
        $student->courses()->detach();
        $student->courses()->attach($courses);

        return $student;
    }

    public function createStudentDeatils($student, $studentData)
    {
        $student->detail()->create([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);

        return $student;
    }

    public function createStudentCourse($student, $courses)
    {
        $student->courses()->attach($courses);

        return $student;
    }

    public function deleteStudentCourse($student)
    {
        $student->courses()->detach();
    }

    public function deleteStudentDetails($stuent)
    {
        $student->detail()->delete();
    }

    public function deleteStudent($student)
    {
        $student->delete();
    }

    public function searchStudent($request)
    {
        $student = Student::query()
            ->select('student.*', DB::raw('count(course_id) as total_courses'))
            ->leftJoin('student_course', 'student.id', '=', 'student_course.student_id')
            ->when($name, function ($q, $name) {
                $q->where('student_name', 'LIKE', '%' . $name . '%');
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
            ->groupBy('student.id')
            ->orderby('id')
            ->get();

        return $student;
    }

    public function profileEditStudentDeatils($student, $studentData)
    {
        $student->detail()->update([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);

        return $student;
    }

    public function profileEditStudentCourse($student)
    {
        $student->courses()->detach();
        $student->courses()->attach($courses);

        return $student;
    }
}
