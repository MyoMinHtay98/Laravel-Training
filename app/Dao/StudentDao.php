<?php

namespace App\Dao;

use App\Models\Student;
use App\Contracts\Dao\StudentDaoInterface;

class StudentDao implements StudentDaoInterface
{
    public function getStudents()
    {
        return Student::paginate(5);
    }

    public function getStudent($id)
    {
        return Student::findOrFail($id);
    }

}
