<?php

namespace App\Contracts\Dao;

interface StudentDaoInterface
{
    public function getStudents();

    public function getStudent($id);
}
