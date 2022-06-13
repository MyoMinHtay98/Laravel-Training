<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CourseService;

class CourseController extends Controller
{
    private $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * show all courses
     *
     * @return void
     */
    public function show()
    {
        $student = Auth::guard('student')->user();
        $teacher = Auth::user();
        $courses = $this->courseService->getCourses();
        return view('course.list', compact('courses', 'student', 'teacher'));
    }

    /**
     * show course details
     *
     * @param int $id
     * @return void
     */
    public function showDetails($id)
    {
        $course = $this->courseService->getCourse($id);

        return view('course.details', ['course' => $course]);
    }

    /**
     * show update page
     *
     * @param int $id
     * @return void
     */
    public function showUpdate($id)
    {
        $course = $this->courseService->getCourse($id);
        return view('course.update', compact('course'));
    }

    /**
     * update course
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $course = $request->validate([
            'course_name' => 'required|max:50',
            'course_dt' => 'required|date',
            'description' => 'required',
            'duration' => 'required|numeric',
        ]);

        Course::where('id', $request->id)->update($course);

        return redirect()->route('course.list');
    }

    /**
     * show create page
     *
     * @return void
     */
    public function showCreate()
    {
        return view('course.create');
    }

    /**
     * create course
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $course = $request->validate([
            'course_name' => 'required|max:50',
            'course_dt' => 'required|date',
            'description' => 'required|max:50',
            'duration' => 'required|numeric',
        ]);

        Course::create($course);

        return redirect()->route('course.list');
    }

    /**
     * delete course
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $course = $this->courseService->getCourse($id);
        $course->students()->detach();
        $course->teachers()->detach();
        $course->delete();

        // Course::where('id', $id)->delete();

        return redirect()->back();
    }

    /**
     * search course
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
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
