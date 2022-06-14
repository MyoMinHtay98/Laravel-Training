<?php

namespace App\Contracts\Services;

interface TeacherServiceInterface
{
    public function getTeachers();

    public function getTeacher($id);

    public function updateTeacher($request, $teacher, $teacherData);

    public function createTeacher($request,  $teacherData);

    public function deleteTeacher($id);

    public function searchTeacher($request);

    public function profileEditTeacher($request, $teacher, $teacherData);

    public function profileDeleteTeacher($teacher);
}