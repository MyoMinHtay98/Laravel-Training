<?php

namespace App\Services;
 
use App\Models\Teacher;
use App\Contracts\Dao\TeacherDaoInterface;
use App\Contracts\Services\TeacherServiceInterface;

class TeacherService implements TeacherServiceInterface {

    private $teacherDao;

    public function __construct(TeacherDaoInterface $teacherDao)
    {
        $this->teacherDao = $teacherDao;
    }

    public function getTeachers()
    {
        return $this->teacherDao->getTeachers();
    }


    public function getTeacher($id)
    {
        return $this->teacherDao->getTeacher($id);
    }
    
}
