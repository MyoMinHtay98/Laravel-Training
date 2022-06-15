<?php

namespace App\Dao;

use App\Contracts\Dao\AuthDaoInterface;
use App\Models\Student;
use App\Models\Teacher;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthDao implements AuthDaoInterface
{
    public function checkUserTeacher()
    {
        return Auth::user();
    }

    public function checkUserStudent()
    {
        return Auth::guard('student')->user();
    }

    public function loginStudent($data)
    {
        return Auth::guard('student')->attempt($data);
    }

    public function loginTeacher($data)
    {
        return Auth::guard('teacher')->attempt($data); 
    }

    public function logoutStudent()
    {   
        return Auth::guard('student')->logout();
    }

    public function logoutTeacher()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login.show');
    }

    public function createForgetPasswordStudent($request)
    {
        $token = Str::random(64);

        $student = DB::table('student_password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        return $student;
    }

    public function createForgetPasswordTeacher($request)
    {
        $token = Str::random(64);

        $teacher = DB::table('teacher_password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        return $teacher;
    }

    public function submitResetPasswordStudent($request)
    {
        $updatePassword = DB::table('student_password_resets')
            ->where('email', $request->email)
            ->first();

        return $updatePassword;
    }

    public function submitResetPasswordTeacher($request)
    {
        $updatePassword = DB::table('teacher_password_resets')
            ->where('email', $request->email)
            ->first();
        return $updatePassword;
    }

   

}
