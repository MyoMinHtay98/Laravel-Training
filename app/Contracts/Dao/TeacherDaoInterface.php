<?php

namespace App\Contracts\Dao;

interface TeacherDaoInterface
{
    public function getTeachers();

    public function getTeacher($id);

    public function updateTeacherDetails($teacher, $teacherData);
    public function updateTeacherCourse($teacher, $course);

    public function createTeacherDetails($teacher, $teacherData);
    public function createTeacherCourse($teacher, $courses);

    public function deleteTeacherCourse($teacher);
    public function deleteTeacherDetails($teacher);
    public function deleteTeacher($teacher);

    public function searchTeacher($request);

    public function updatePasswordTeacher($request);

    public function checkPassword($request);

}
