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
    
}
