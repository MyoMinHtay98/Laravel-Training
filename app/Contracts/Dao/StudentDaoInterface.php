<?php

namespace App\Contracts\Dao;

interface StudentDaoInterface
{
    public function getStudents();

    public function getStudent($id);

    public function updateStudentDetails($student, $studentData);
    public function updateStudentCourse($student, $courses);

    public function createStudentDetails($student, $studentData);
    public function createStudentCourse($student, $courses);

    public function deleteStudentDetails($student);
    public function deleteStudentCourse($student);
    public function deleteStudent($student);

    public function searchStudent($request);

    public function updatePasswordStudent($request);

    public function checkPassword($request);
}
