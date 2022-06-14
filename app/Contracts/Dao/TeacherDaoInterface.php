<?php

namespace App\Contracts\Dao;

interface TeacherDaoInterface
{
    public function getTeachers();

    public function getTeacher($id);

    public function updateTeacherDeatils($teacher, $teacherData);
    public function updateTeacherCourse($teacher, $course);

    public function createTeacherDeatils($teacher, $teacherData);
    public function createTeacherCourse($teacher, $courses);

    public function deleteTeacherDetails($id);
    public function deleteTeacherCourse($id);
    public function deleteTeacher($id);

    public function searchTeacher($request);

    public function profileEditTeacherDeatils($teacher, $teacherData);
    public function profileEditTeacherCourse($teacher);
}
