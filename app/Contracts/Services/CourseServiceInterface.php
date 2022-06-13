<?php

namespace App\Contracts\Services;

interface CourseServiceInterface
{
    public function getCourses();

    public function getCourse($id);
}