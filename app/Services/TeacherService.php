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

    public function updateTeacher($request, $teacher, $teacherData)
    {
        return $this->teacherDao->updateTeacher($request, $teacher, $teacherData);
    }

    public function createTeacher($request,  $teacherData)
    {
        return $this->teacherDao->createTeacher($request,  $teacherData);
    }

    public function deleteTeacher($id)
    {
        return $this->teacherDao->deleteTeacher($id);
    }

    public function searchTeacher($request)
    {
        return $this->teacherDao->searchTeacher($request);
    }

    public function profileEditTeacher($request, $teacher, $teacherData)
    {
        return $this->teacherDao->profileEditTeacher($request, $teacher, $teacherData);
    }

    public function profileDeleteTeacher($teacher)
    {
        return $this->teacherDao->profileDeleteTeacher($teacher);
    }
    
}
