<?php

namespace App\Services;
 
use App\Models\Course;
use App\Contracts\Dao\CourseDaoInterface;
use App\Contracts\Services\CourseServiceInterface;

class CourseService implements CourseServiceInterface {

    private $CourseDao;

    public function __construct(CourseDaoInterface $CourseDao)
    {
        $this->courseDao = $CourseDao;
    }

    public function getCourses()
    {
        return $this->courseDao->getCourses();
    }


    public function getCourse($id)
    {
        return $this->courseDao->getCourse($id);
    }
    
}
