<?php

namespace App\Dao;

use App\Contracts\Dao\StudentDaoInterface;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function updateStudentDetails($student, $studentData)
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

    public function createStudentDetails($student, $studentData)
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
        return $student->courses()->detach();
        // dd($student->detail());
    }

    public function deleteStudentDetails($student)
    {
        return $student->detail()->delete();
    }

    public function deleteStudent($student)
    {
        return $student->delete();
    }

    public function searchStudent($request)
    {
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $isActive = $request->is_active;
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

    public function updatePasswordStudent($request)
    {
        Student::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('student_password_resets')->where('email', $request->email)->delete();

        return true;
        // return redirect()->route('student.login')->with('message', 'Your password has been changed!');
        // return back()->withInput()->with('error', 'Invalid token!');
    }

    public function checkPassword($request)
    {
        $student = Student::where('id', $request->id)->update(
            ['password' => Hash::make($request->newPassword)]
        );

        return $student;
    }

}
