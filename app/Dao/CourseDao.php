<?php

namespace App\Dao;

use App\Models\Course;
use App\Contracts\Dao\CourseDaoInterface;

class CourseDao implements CourseDaoInterface
{
    public function getCourses()
    {
        return Course::paginate(5);
    }

    public function getCourse($id)
    {
        return Course::findOrFail($id);
    }

}
