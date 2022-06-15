<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\AuthService;
use App\Services\CourseService;
use App\Services\StudentService;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    private $studentService, $authService, $courseService;

    public function __construct(StudentService $studentService, CourseService $courseService, AuthService $authService)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->authService = $authService;
    }

    /**
     * show all students
     *
     * @return void
     */
    public function show()
    {
        $students = $this->studentService->getStudents();
        $teacher = $this->authService->checkUserTeacher();
        return view('student.list', compact('teacher', 'students'));
    }

    /**
     * show student details
     *
     * @param int $id
     * @return array
     */
    public function showDetails($id)
    {
        $student = $this->studentService->getStudent($id);

        return view('student.details', compact('student'));
    }

    /**
     * show update page
     *
     * @param int $id
     * @return void
     */
    public function showUpdate($id)
    {
        $student = $this->studentService->getStudent($id);
        $courses = $this->courseService->getAllCourses();

        return view('student.update', compact('student', 'courses'));
    }

    /**
     * update student
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $studentData = $request->validate([
            'student_name' => 'required|max:50',
            'father_name' => 'required|max:50',
            'mother_name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:student,email,'.$request->id,
            'gender' => 'required',
            'is_active' => 'required',
            'dob' => 'required|date',
            'age' => 'required|numeric',
            'courses' => 'required|array',
            'address' => 'required|max:100',
            'hobby' => 'required|max:100',
            'file_path' => 'required',
        ]);
        $courses = $studentData['courses'];
        $student = $this->studentService->getStudent($request->id);

        $this->studentService->updateStudent($request, $student, $studentData, $courses);

        return redirect()->route('student.list');
    }

    /**
     * show create page
     *
     * @return void
     */
    public function showCreate()
    {
        $courses = $this->courseService->getAllCourses();

        return view('student.create', compact('courses'));
    }

    /**
     * create student
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $studentData = $request->validate([
            'student_name' => 'required|max:50',
            'father_name' => 'required|max:50',
            'mother_name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:student',
            'password' => 'required|min:8|max:50',
            'gender' => 'required',
            'is_active' => 'required|boolean',
            'dob' => 'required|date',
            'age' => 'required|numeric',
            'courses' => 'required|array',
            'address' => 'required|max:100',
            'hobby' => 'required|max:100',
            'file_path' => 'required',
        ]);
        $courses = $studentData['courses'];
        $this->studentService->createStudent($request, $studentData, $courses);

        return redirect()->route('student.list');
    }

    /**
     * delete student
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $student = $this->studentService->getStudent($id);
        $this->studentService->deleteStudent($student);

        return redirect()->back();
    }

    /**
     * show change password page
     *
     * @param int $id
     * @return void
     */
    public function showPassword($id)
    {
        $student = $this->studentService->getStudent($id);

        return view('student.change_password', compact('student'));
    }

     /**
     * change teacher password
     *
     * @param Request $request
     * @return void
     */
    public function checkPassword(Request $request)
    {
        $student = $this->studentService->checkPassword($request);

        if ($student) {
            return redirect()->back()->with(["error" => "Old Password Was Wrong"]);
        }
        return redirect()->route('student.list');
    }

    /**
     * search student
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        $result = $this->studentService->searchStudent($request);

        return view('student.search', compact('result'));
    }

    /**
     * show login page
     *
     * @return void
     */
    public function showLogin()
    {
        return view('student.login');
    }

    /**
     * student login
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $student = $request->validate([
            'email' => 'required|email|max:30',
            'password' => 'required|min:8|max:20',
        ]);

        $studentLogin = $this->authService->loginStudent($student);

       if($studentLogin){
         return redirect()->route('student.profile.show');
        }
        return back()->with(["error" => "Your Email or Password Was Wrong"]);
    }

    /**
     * student logout
     *
     * @return void
     */
    public function logout()
    {
        $this->authService->logoutStudent();
        return redirect()->route('student.login.show');
    }

    /**
     * student profile
     *
     * @param int $id
     * @return void
     */
    public function profile()
    {
        $student = $this->authService->checkUserStudent();
        return view('student.profile', compact('student'));
    }

    /**
     * show profile edit page
     *
     * @param int $id
     * @return void
     */
    public function showProfileEdit()
    {
        $student = $this->authService->checkUserStudent();
        $courses = $this->courseService->getCourses();
        return view('student.profileEdit', compact('student', 'courses'));
    }

    /**
     * edit user
     *
     * @param Request $request
     * @return void
     */
    public function profileEdit(Request $request)
    {
        $studentData = $request->validate([
            'student_name' => 'required|max:50',
            'father_name' => 'required|max:50',
            'mother_name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:student,email,'.$request->id,
            'gender' => 'required',
            'is_active' => 'required',
            'dob' => 'required|date',
            'age' => 'required|numeric',
            'courses' => 'required|array',
            'address' => 'required|max:100',
            'hobby' => 'required|max:100',
        ]);

        $student = $this->authService->checkUserStudent();
        $this->studentService->updateStudent($request, $student, $studentData);

        return redirect()->route('student.profile.show');
    }

    /**
     * delete student
     *
     * @return void
     */
    public function profileDelete()
    {
        $student = $this->authService->checkUserStudent();
        $this->studentService->deleteStudent($student);

        return redirect()->back();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        return view('student.forgetPassword');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([

            'email' => 'required|email|exists:student',
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
        return view('student.forgetPasswordLink', ['token' => $token]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:student',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $student = $this->authService->checkPasswordStudent($request);

        if($student)
        {
            return redirect()->route('student.login')->with('message', 'Your password has been changed!');
        }
        return back()->withInput()->with('error', 'Invalid token!');

    }

}
