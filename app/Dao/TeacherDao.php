<?php

namespace App\Dao;

use App\Contracts\Dao\TeacherDaoInterface;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function updateTeacherDetails($teacher, $teacherData)
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

    public function createTeacherDetails($teacher, $teacherData)
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
    }

    public function deleteTeacher($teacher)
    {   
        return $teacher->delete();
    }

    public function deleteTeacherCourse($teacher)
    {
        return $teacher->courses()->detach();
    }

    public function deleteTeacherDetails($teacher)
    {
        return $teacher->detail()->delete();
    }

    public function searchTeacher($request)
    {
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $isActive = $request->is_active;
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

    public function updatePasswordTeacher($request)
    {
        Teacher::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('teacher_password_resets')->where('email', $request->email)->delete();
        // return redirect()->route('teacher.login')->with('message', 'Your password has been changed!');
        // return back()->withInput()->with('error', 'Invalid token!');

        return true;
    }

    public function checkPassword($request)
    {
        $teacher = Teacher::where('id', $request->id)->update(
            ['password' => Hash::make($request->newPassword)]
        );

        return $teacher;
    }

}
