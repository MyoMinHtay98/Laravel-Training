<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Services\TeacherService;
use App\Services\AuthService;
use App\Services\CourseService;
use App\Services\StudentService;

class TeacherController extends Controller
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
     * show all teachers
     *
     * @return void
     */
    public function show()
    {
        $teachers = $this->teacherService->getTeachers();
        return view('teacher.list', compact('teachers'));
    }

    /**
     * show teacher deatils
     *
     * @param int $id
     * @return void
     */
    public function showDetails($id)
    {
        $teacher = $this->teacherService->getTeacher($id);
        return view('teacher.details', compact('teacher'));
    }

    /**
     * show update page
     *
     * @param int $id
     * @return void
     */
    public function showUpdate($id)
    {
        $courses = $this->courseService->getCourses();
        $teacher = $this->teacherService->getTeacher($id);
        return view('teacher.update', compact('teacher', 'courses'));
    }

    /**
     * update teacher
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $teacherData = $request->validate([
            'teacher_name' => 'required|max:50',
            'father_name' => 'required|max:50',
            'mother_name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'nrc' => 'required',
            'gender' => 'required',
            'is_active' => 'required',
            'dob' => 'required|date',
            'age' => 'required|numeric',
            'courses' => 'required|array',
            'address' => 'required|max:100',
            'hobby' => 'required|max:100',
            'file_path' => 'required',
        ]);

        $teacher = $this->teacherService->getTeacher($request->id);

        $this->teacherService->updateTeacher($request, $teacher, $teacherData);

        return redirect()->route('teacher.list');
    }

    /**
     * show create page
     *
     * @return void
     */
    public function showCreate()
    {
        $courses = $this->courseService->getCourses();

        return view('teacher.create', compact('courses'));
    }

    /**
     * create teacher
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $teacherData = $request->validate([
            'teacher_name' => 'required|max:50',
            'father_name' => 'required|max:50',
            'mother_name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:teacher',
            'password' => 'required|min:8|max:20',
            'nrc' => 'required|max:20',
            'gender' => 'required',
            'is_active' => 'required',
            'dob' => 'required|date',
            'age' => 'required|numeric',
            'courses' => 'required|array',
            'address' => 'required|max:100',
            'hobby' => 'required|max:100',
        ]);

        $this->teacherService->createTeacher($request, $teacherData);

        return redirect()->route('teacher.list');
    }

    /**
     * delete teacher
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $teacher = $this->teacherService->deleteTeacher($id);

        return redirect()->back();
    }

    /**
     * show change password
     *
     * @param int $id
     * @return void
     */
    public function showPassword($id)
    {
        $teacher = $this->teacherService->getTeacher($id);
        return view('teacher.change_password', compact('teacher'));
    }

    /**
     * search teacher
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        $result = $this->teacherService->searchTeacher($request);

        return view('teacher.search', compact('result'));
    }

    /**
     * show login page
     *
     * @return void
     */
    public function showLogin()
    {
        return view('teacher.login');
    }

    /**
     * teacher login
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $teacher = $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|min:8|max:20',
        ]);

        return $this->authService->loginTeacher($teacher);
    }

    /**
     * teacher logout
     *
     * @return void
     */
    public function logout()
    {
        return $this->authService->logoutTeacher();
    }

    /**
     * teacher profile
     *
     * @param int $id
     * @return void
     */
    public function profile()
    {
        $teacher =  $this->authService->checkUserTeacher();
        return view('teacher.profile', compact('teacher'));
    }

    /**
     * show profile edit page
     *
     * @param int $id
     * @return void
     */
    public function showProfileEdit()
    {
        $teacher = $this->authService->checkUserTeacher();
        $courses = $this->courseService->getCourses();
        return view('teacher.profileEdit', compact('teacher', 'courses'));
    }

    /**
     * edit teacher
     *
     * @param Request $request
     * @return void
     */
    public function profileEdit(Request $request)
    {
        $teacherData = $request->validate([
            'teacher_name' => 'required|max:50',
            'father_name' => 'required|max:50',
            'mother_name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'nrc' => 'required',
            'gender' => 'required',
            'is_active' => 'required',
            'dob' => 'required|date',
            'age' => 'required|numeric',
            'courses' => 'required|array',
            'address' => 'required|max:100',
            'hobby' => 'required|max:100',
        ]);

        $teacher = $this->authService->checkUserTeacher();
        $this->teacherService->profileEditTeacher($request, $teacher, $teacherData);

        return redirect()->route('teacher.list');
    }

    /**
     * delete teacher
     *
     * @return void
     */
    public function profileDelete()
    {
        $teacher = $this->authService->checkUserTeacher();
        $this->teacherService->profileDeleteTeacher($teacher);

        return redirect()->back();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        return view('teacher.forgetpassword');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:teacher',
        ]);

        return $this->authService->submitForgetPasswordTeacher($request);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token)
    {
        return view('teacher.forgetPasswordLink', ['token' => $token]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:teacher',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        return $this->authService->submitResetPasswordTeacher($request);
    }
}
