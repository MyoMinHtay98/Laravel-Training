<?php

namespace App\Contracts\Dao;

interface CourseDaoInterface
{
    public function getCourses();

    public function getCourse($id);
}
