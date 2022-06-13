<?php

namespace App\Dao;

use App\Models\Teacher;
use App\Contracts\Dao\TeacherDaoInterface;

class TeacherDao implements TeacherDaoInterface
{
    public function getTeachers()
    {
        return Teacher::paginate(5);
    }

    public function getTeacher($id)
    {
        return Teacher::findOrFail($id);
    }

}
