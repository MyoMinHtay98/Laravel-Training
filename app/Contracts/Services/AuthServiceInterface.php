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

    public function mailSentStudent($request);

    public function mailSentTeacher($request);

    public function checkPasswordStudent($request);

    public function checkPasswordTeacher($request);
}