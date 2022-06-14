<?php

namespace App\Services;
 
use App\Models\Student;
use App\Contracts\Dao\StudentDaoInterface;
use App\Contracts\Services\StudentServiceInterface;

class StudentService implements StudentServiceInterface {

    private $studentDao;

    public function __construct(StudentDaoInterface $studentDao)
    {
        $this->studentDao = $studentDao;
    }

    public function getStudents()
    {
        return $this->studentDao->getStudents();
    }

    public function getStudent($id)
    {
        return $this->studentDao->getStudent($id);
    }

    public function updateStudent($request, $student, $studentData)
    {
        return $this->studentDao->updateStudent($request, $student, $studentData);
    }

    public function createStudent($request,  $studentData)
    {
        return $this->studentDao->createStudent($request,  $studentData);
    }

    public function deleteStudent($id)
    {
        return $this->studentDao->deleteStudent($id);
    }

    public function searchStudent($request)
    {
        return $this->studentDao->searchStudent($request);
    }

    public function profileEditStudent($request, $student, $studentData)
    {
        return $this->studentDao->profileEditStudent($request, $student, $studentData);
    }

    public function profileDeleteStudent($student)
    {
        return $this->studentDao->profileDeleteStudent($student);
    }
}
