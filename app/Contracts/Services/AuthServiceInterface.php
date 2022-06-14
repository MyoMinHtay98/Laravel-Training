<?php

namespace App\Contracts\Services;

interface AuthServiceInterface
{
    public function checkUserTeacher();

    public function checkUserStudent();

    public function loginStudent($data);

    public function logoutStudent();

    public function loginTeacher($data);

    public function logoutTeacher();

    public function submitForgetPasswordStudent($request);

    public function submitResetPasswordStudent($request);

    public function submitForgetPasswordTeacher($request);

    public function submitResetPasswordTeacher($request);
}