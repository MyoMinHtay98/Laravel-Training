<?php

namespace App\Services;

use App\Contracts\Dao\AuthDaoInterface;
use App\Contracts\Services\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService implements AuthServiceInterface
{

    private $AuthDao;

    public function __construct(AuthDaoInterface $AuthDao)
    {
        $this->authDao = $AuthDao;
    }

    public function checkUserTeacher()
    {
        return $this->authDao->checkUserTeacher();
    }

    public function checkUserStudent()
    {
        return $this->authDao->checkUserStudent();
    }

    public function loginStudent($data)
    {
        return $this->authDao->loginStudent($data);
    }

    public function loginTeacher($data)
    {
        return $this->authDao->loginTeacher($data);
    }

    public function logoutStudent()
    {
        return $this->authDao->logoutStudent();
    }

    public function logoutTeacher()
    {
        return $this->authDao->logoutTeacher();
    }

    public function mailSentStudent($request)
    {
        $this->authDao->createForgetPasswordStudent($request);
        Mail::send('student.forgetPasswordEmail', ['token' => $token], function ($message) use ($request) {
            $message
                ->to($request->email, 'Receiver ABC')
                ->subject('Laravel Basic Testing Mail')
                ->from('xyz@gmail.com', 'Sender ABC');
        });

        return true;
    }

    public function mailSentTeacher($request)
    {
        $this->authDao->createForgetPasswordTeacher($request);
        Mail::send('teacher.forgetPasswordEmail', ['token' => $token], function ($message) use ($request) {
            $message
                ->to($request->email, 'Receiver ABC')
                ->subject('Laravel Basic Testing Mail')
                ->from('xyz@gmail.com', 'Sender ABC');
        });

        return true;
    }


    public function checkPasswordStudent($request)
    {
        $updatepassword = $this->authDao->submitResetPasswordStudent($request);
        $token = $request->token;
        if ($updatePassword && Hash::check($token, $updatePassword->token)) {
            $this->authDao->updatePasswordStudent();
        }
    }

    public function checkPasswordTeacher($request)
    {
        $updatepassword = $this->authDao->submitResetPasswordTeacher($request);
        $token = $request->token;
        if ($updatePassword && Hash::check($token, $updatePassword->token)) {
            $this->authDao->updatePasswordTeacher();
            return true;
        }
        return false;
    }

}
