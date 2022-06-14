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
        $course = Course::where('id', $request->id)->update($course);
        return $course;
    }

    public function createCourse()
    {
        $course = Course::create($course);
        return $course;
    }

    public function deleteCourse($course)
    {
        $course->students()->detach();
        $course->teachers()->detach();
        $course->delete();

        return $course;
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

       return view('course.search', compact('result'));
    }

}
