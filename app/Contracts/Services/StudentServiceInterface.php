<?php

namespace App\Contracts\Services;

interface StudentServiceInterface
{
    public function getStudents();

    public function getStudent($id);

    public function updateStudent($request, $student, $studentData);

    public function createStudent($request,  $studentData);

    public function deleteStudent($id);

    public function searchStudent($request);

    public function profileEditStudent($request, $student, $studentData);

    public function profileDeleteStudent($student);
}