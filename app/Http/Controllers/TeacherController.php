<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Services\AuthService;
use App\Services\CourseService;
use App\Services\StudentService;
use App\Services\TeacherService;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Http\Request;

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
        $courses = $this->courseService->getAllCourses();
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
        $courses = $teacherData['courses'];
        $teacher = $this->teacherService->getTeacher($request->id);

        $this->teacherService->updateTeacher($request, $teacher, $teacherData, $courses);

        return redirect()->route('teacher.list');
    }

    /**
     * show create page
     *
     * @return void
     */
    public function showCreate()
    {
        $courses = $this->courseService->getAllCourses();

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
        $courses = $teacherData['courses'];
        $this->teacherService->createTeacher($request, $teacherData, $courses);

        return redirect()->route('teacher.list');
    }

    /**
     * delete teacher
     *
     * @return void
     */
    public function delete($id)
    {
        $teacher = $this->teacherService->getTeacher($id);
        $this->teacherService->deleteTeacher($teacher);

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
     * change teacher password
     *
     * @param Request $request
     * @return void
     */
    public function checkPassword(Request $request)
    {
        $teacher = $this->teacherService->checkPassword($request);

        if ($teacher) {
            return redirect()->back()->with(["error" => "Old Password Was Wrong"]);
        }
        return redirect()->route('teacher.list');
    }

    /**
     * search teacher
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $isActive = $request->is_active;
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

        $teacherLogin = $this->authService->loginTeacher($teacher);
        if ($teacherLogin) {
            return redirect()->route('teacher.profile.show');
        }
        return back()->with(["error" => "Your Email or Password Was Wrong"]);
    }

    /**
     * teacher logout
     *
     * @return void
     */
    public function logout()
    {
        $this->authService->logoutTeacher();
        return redirect()->route('teacher.login.show');
    }

    /**
     * teacher profile
     *
     * @param int $id
     * @return void
     */
    public function profile()
    {
        $teacher = $this->authService->checkUserTeacher();
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
        $courses = $teacherData['courses'];
        $teacher = $this->authService->checkUserTeacher();
        $this->teacherService->updateTeacher($request, $teacher, $teacherData, $courses);

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
        $this->teacherService->deleteTeacher($teacher);

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

        $this->authService->mailSentStudent($request);
        return back()->with('message', 'We have e-mailed your password reset link!');
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

        $teacher = $this->authService->checkPasswordTeacher($request);

        if ($teacher) {
            return redirect()->route('teacher.login')->with('message', 'Your password has been changed!');
        }
        return back()->withInput()->with('error', 'Invalid token!');
    }
}
