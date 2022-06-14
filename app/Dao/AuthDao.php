<?php

namespace App\Dao;

use Auth;
use App\Contracts\Dao\AuthDaoInterface;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        if (Auth::guard('student')->attempt($data)) {
            return redirect()->route('student.profile.show');
        }

        return back()->with(["error" => "Your Email or Password Was Wrong"]);
    }

    public function loginTeacher($data)
    {
        if (Auth::guard('teacher')->attempt($data)) {
            return redirect()->route('teacher.profile.show');
        }

        return back()->with(["error" => "Your Email or Password Was Wrong"]);
    }

    public function logoutStudent()
    {
        Auth::guard('student')->logout();
        return redirect()->route('student.login.show');
    }

    public function logoutTeacher()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login.show');
    }

    public function submitForgetPasswordStudent($request)
    {
        $token = Str::random(64);

        DB::table('student_password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);
        Mail::send('student.forgetPasswordEmail', ['token' => $token], function ($message) use ($request) {
            $message
                ->to($request->email, 'Receiver ABC')
                ->subject('Laravel Basic Testing Mail')
                ->from('xyz@gmail.com', 'Sender ABC');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function submitForgetPasswordTeacher($request)
    {
        $token = Str::random(64);

        DB::table('teacher_password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);
        Mail::send('teacher.forgetPasswordEmail', ['token' => $token], function ($message) use ($request) {
            $message
                ->to($request->email, 'Receiver ABC')
                ->subject('Laravel Basic Testing Mail')
                ->from('xyz@gmail.com', 'Sender ABC');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function submitResetPasswordStudent($request)
    {
        $updatePassword = DB::table('student_password_resets')
            ->where('email', $request->email)
            ->first();
        $token = $request->token;
        if ($updatePassword && Hash::check($token, $updatePassword->token)) {

            Student::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('student_password_resets')->where('email', $request->email)->delete();
            return redirect()->route('student.login')->with('message', 'Your password has been changed!');
        }
        return back()->withInput()->with('error', 'Invalid token!');
    }

    public function submitResetPasswordTeacher($request)
    {
        $updatePassword = DB::table('teacher_password_resets')
            ->where('email', $request->email)
            ->first();
        $token = $request->token;
        if ($updatePassword && Hash::check($token, $updatePassword->token)) {

            Teacher::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('teacher_password_resets')->where('email', $request->email)->delete();
            return redirect()->route('teacher.login')->with('message', 'Your password has been changed!');
        }
        return back()->withInput()->with('error', 'Invalid token!');
    }

}
