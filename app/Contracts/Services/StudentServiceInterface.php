<?php

namespace App\Contracts\Services;

interface StudentServiceInterface
{
    public function getStudents();

    public function getStudent($id);
}