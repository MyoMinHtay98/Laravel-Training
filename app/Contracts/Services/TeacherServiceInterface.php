<?php

namespace App\Contracts\Services;

interface TeacherServiceInterface
{
    public function getTeachers();

    public function getTeacher($id);
}