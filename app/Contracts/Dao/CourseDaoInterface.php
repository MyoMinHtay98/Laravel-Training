<?php

namespace App\Contracts\Dao;

interface CourseDaoInterface
{
    public function getCourses();

    public function getCourse($id);

    public function updateCourse($courseData);

    public function createCourse();

    public function deleteCourse($course);
    public function deleteStudentCourse($course);
    public function deleteTeacherCourse($course);

    public function searchCourse($request);
}
