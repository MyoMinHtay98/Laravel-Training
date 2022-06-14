<?php

namespace App\Services;
 
use App\Contracts\Dao\AuthDaoInterface;
use App\Contracts\Services\AuthServiceInterface;

class AuthService implements AuthServiceInterface {

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

    public function submitForgetPasswordStudent($request)
    {
        return $this->authDao->submitForgetPasswordStudent($request);
    }

    public function submitResetPasswordStudent($request)
    {
        return $this->authDao->submitResetPasswordStudent($request);
    }

    public function submitForgetPasswordTeacher($request)
    {
        return $this->authDao->submitForgetPasswordTeacher($request);
    }

    public function submitResetPasswordTeacher($request)
    {
        return $this->authDao->submitResetPasswordTeacher($request);
    }
}


