<?php

namespace App\Contracts\Services;

interface TeacherServiceInterface
{
    public function getTeachers();

    public function getTeacher($id);

    public function updateTeacher($request, $teacher, $teacherData, $courses);

    public function createTeacher($request,  $teacherData, $courses);

    public function deleteTeacher($id);

    public function searchTeacher($request);

}