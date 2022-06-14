<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CourseService;
use App\Services\AuthService;
use App\Services\TeacherService;
use App\Services\StudentService;

class CourseController extends Controller
{
    private $studentService, $authService, $courseService, $teacherService;

    public function __construct(StudentService $studentService, CourseService $courseService, AuthService $authService, TeacherService $teacherService)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->authService = $authService;
        $this->teacherService = $teacherService;
    }

    /**
     * show all courses
     *
     * @return void
     */
    public function show()
    {
        $student = $this->authService->checkUserStudent();
        $teacher = $this->authService->checkUserTeacher();
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
        $courseData = $request->validate([
            'course_name' => 'required|max:50',
            'course_dt' => 'required|date',
            'description' => 'required',
            'duration' => 'required|numeric',
        ]);

        $this->courseService->updateCourse($courseData);

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

        $this->courseService->createCourse();

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
        $this->courseService->deleteCourse($course);

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
        return redirect()->route('course.search');  
    }
}
