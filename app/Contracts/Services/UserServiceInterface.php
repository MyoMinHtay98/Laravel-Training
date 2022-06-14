<?php

namespace App\Contracts\Services;

interface CourseServiceInterface
{
    public function getCourses();

    public function getCourse($id);

    public function updateCourse($courseData);

    public function createCourse();

    public function deleteCourse($course);

    public function searchCourse($request);
}