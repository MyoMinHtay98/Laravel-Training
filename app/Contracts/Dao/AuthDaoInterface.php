<?php

namespace App\Contracts\Dao;

interface AuthDaoInterface
{
    public function checkUserTeacher();

    public function checkUserStudent();

    public function loginStudent($data);

    public function logoutStudent();

    public function loginTeacher($data);

    public function logoutTeacher();

    public function createForgetPasswordStudent($request);

    public function submitResetPasswordStudent($request);

    public function createForgetPasswordTeacher($request);

    public function submitResetPasswordTeacher($request);
}
