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
    
    public function updateCourse($courseData)
    {
        return $this->courseDao->updateCourse($courseData);
    }

    public function createCourse()
    {
        return $this->courseDao->createCourse();
    }

    public function deleteCourse($course)
    {
        return $this->courseDao->deleteCourse($course);
    }

    public function searchCourse($request)
    {
        return $this->courseDao->searchCourse($request);
    }
}
