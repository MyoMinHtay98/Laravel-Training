<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Services\StudentService;

class StudentController extends Controller
{
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }


    /**
     * show all students
     *
     * @return void
     */
    public function show()
    {
        $students = $this->studentService->getStudents();
        $teacher = Auth::user();
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
        $student =  $this->studentService->getStudent($id);
        $courses = Course::all();
        // $student = $this->studentService->getStudent($id);
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
            'email' => 'required|email|max:50',
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
        unset($studentData['courses']);

        $studentImage = $request->file_path;
        $req_id = $request->id;
        $student =$this->studentService->getStudent($req_id);

        if (isset($studentImage)) {
            $data = Student::where('id', $request->id)->first();

            $fileName = $data['file_path'];
            if (File::exists(public_path() . '/uploads/' . $fileName)) {
                File::delete(public_path() . '/uploads/' . $fileName);
            }
            $file = $request->file('file_path');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path() . '/uploads/', $fileName); //move path to $fileName
            $studentData['file_path'] = $fileName;
        }
        $student->update($studentData);

        $student->detail()->update([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);
        $student->courses()->detach();

        $student->courses()->attach($courses);

        return redirect()->route('student.list');
    }

    /**
     * show create page
     *
     * @return void
     */
    public function showCreate()
    {
        $courses = Course::all();

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
            'email' => 'required|email|max:50',
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

        $studentData['password'] = bcrypt($studentData['password']);
        $courses = $studentData['courses'];
        unset($studentData['courses']);

        $student = Student::create($studentData);

        if ($request->hasfile('file_path')) {
            $file = $request->file('file_path');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move(public_path() . '/uploads/', $filename);
            $student->file_path = $filename;
        }
        $student->save();
        $student->detail()->create([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);

        $student->courses()->attach($courses);

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
        $student->courses()->detach();
        $student->detail()->delete();
        $student->delete();

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
     * change student password
     *
     * @param Request $request
     * @return void
     */
    public function checkPassword(Request $request)
    {
        $student = $this->studentService->getStudent($id);
        if (!Hash::check($request->oldPassword, $student->password)) {
            return back()->with(["error" => "Old Password Was Wrong"]);
        }

        Student::where('id', $request->id)->update(
            ['password' => Hash::make($request->newPassword)]
        );
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
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $isActive = $request->is_active;
        $result = Student::query()
            ->select('student.*', DB::raw('count(course_id) as total_courses'))
            ->leftJoin('student_course', 'student.id', '=', 'student_course.student_id')
            ->when($name, function ($q, $name) {
                $q->where('student_name', 'LIKE', '%' . $name . '%');
            })
            ->when($email, function ($q, $email) {
                $q->where('email', 'LIKE', '%' . $email . '%');
            })
            ->when($gender, function ($q, $gender) {
                $q->where('gender', $gender);
            })
            ->when($isActive, function ($q, $isActive) {
                $q->whereIn('is_active', $isActive);
            })
            ->groupBy('student.id')
            ->orderby('id')
            ->get();
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

        if (Auth::guard('student')->attempt($student)) {
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
        Auth::guard('student')->logout();
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
        $student = Auth::guard('student')->user();
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
        $student = Auth::guard('student')->user();
        $courses = Course::all();
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
            'email' => 'required|email|max:50',
            'gender' => 'required',
            'is_active' => 'required',
            'dob' => 'required|date',
            'age' => 'required|numeric',
            'courses' => 'required|array',
            'address' => 'required|max:100',
            'hobby' => 'required|max:100',
        ]);

        $courses = $studentData['courses'];

        unset($studentData['courses']);

        $student = Auth::guard('student')->user();
        $student->update($studentData);

        $student->detail()->update([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);
        $student->courses()->detach();
        $student->courses()->attach($courses);

        return redirect()->route('student.profile.show');
    }

    /**
     * delete student
     *
     * @return void
     */
    public function profileDelete()
    {
        $student = Auth::guard('student')->user();
        $student->courses()->detach();
        $student->detail()->delete();
        $student->delete();

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

        $token = Str::random(64);

        DB::table('student_password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);
        Mail::send('student.forgetPasswordEmail', ['token' => $token], function ($message) use ($request) {
            $message
                ->to($request->email, 'Receiver ABC')
                ->subject('Laravel Basic Testing Mail')
                ->from('xyz@gmail.com', 'Sender ABC');
        });

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

        $updatePassword = DB::table('student_password_resets')
            ->where('email', $request->email)
            ->first();
        $token = $request->token;
        if ($updatePassword && Hash::check($token, $updatePassword->token)) {

            Student::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('student_password_resets')->where('email', $request->email)->delete();
            return redirect()->route('student.login')->with('message', 'Your password has been changed!');
        }
        return back()->withInput()->with('error', 'Invalid token!');

    }

}
