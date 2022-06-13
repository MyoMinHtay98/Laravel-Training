<?php

namespace App\Contracts\Dao;

interface TeacherDaoInterface
{
    public function getTeachers();

    public function getTeacher($id);
}
