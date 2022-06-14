<?php

namespace App\Contracts\Dao;

interface StudentDaoInterface
{
    public function getStudents();

    public function getStudent($id);

    public function updateStudentDeatils($student, $studentData);
    public function updateStudentCourse($student, $courses);

    public function createStudentDeatils($student, $studentData);
    public function createStudentCourse($student, $courses);

    public function deleteStudentDetails($id);
    public function deleteStudentCourse($id);
    public function deleteStudent($id);

    public function searchStudent($request);

    public function profileEditStudentDeatils($student, $studentData);
    public function profileEditStudentCourse($student);
}
