<?php

namespace App\Dao;

use App\Models\Course;
use App\Contracts\Dao\CourseDaoInterface;

class CourseDao implements CourseDaoInterface
{
    public function getCourses()
    {
        return Course::paginate(5);
    }

    public function getCourse($id)
    {
        return Course::findOrFail($id);
    }

    public function updateCourse($courseData)
    {
        return Course::where('id', $request->id)->update($courseData);
    }

    public function createCourse()
    {
        return Course::create($course);
    }

    public function deleteCourse($course)
    {   
        return $course->delete();
    }

    public function deleteStudentCourse($course)
    {
        return $course->students()->detach();
    }

    public function deleteTeacherCourse($course)
    {
        return $course->teachers()->detach();
    }

    public function searchCourse($request)
    {
        $search = $request->search;
        $result = Course::where('course_name', 'like', '%' . $search . '%')
            ->orWhere('course_dt', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('duration', 'like', '%' . $search . '%')
            ->orderBy('id')
            ->paginate(5);

       return $result;
    }

}
