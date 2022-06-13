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

class TeacherController extends Controller
{
    /**
     * show all teachers
     *
     * @return void
     */
    public function show()
    {
        $teachers = Teacher::paginate(5);
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
        $teacher = Teacher::findOrFail($id);
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
        $courses = Course::all();
        $teacher = Teacher::findOrFail($id);
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
        unset($teacherData['courses']);

        $teacherImage = $request->file_path;
        $req_id = $request->id;
        $teacher = Teacher::find($req_id);

        if (isset($teacherImage)) {
            $data = Teacher::where('id', $request->id)->first();

            $fileName = $data['file_path'];
            if (File::exists(public_path() . '/uploads/' . $fileName)) {
                File::delete(public_path() . '/uploads/' . $fileName);
            }
            $file = $request->file('file_path');
            $extention = $file->getClientOriginalName();
            $filename = time() . '.' . $extention;
            $file->move(public_path() . '/uploads/', $filename);
            $teacher->file_path = $filename;
        }
        $teacher->update($teacherData);

        $teacher->detail()->update([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);
        $teacher->courses()->detach();

        $teacher->courses()->attach($courses);

        return redirect()->route('teacher.list');
    }

    /**
     * show create page
     *
     * @return void
     */
    public function showCreate()
    {
        $courses = Course::all();

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
            'email' => 'required|email|max:50',
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
        $teacherData['password'] = bcrypt($teacherData['password']);
        $courses = $teacherData['courses'];
        unset($teacherData['courses']);

        $teacher = Teacher::create($teacherData);

        if ($request->hasfile('file_path')) {
            $file = $request->file('file_path');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move(public_path() . '/uploads/', $filename);
            $teacher->file_path = $filename;
        }
        $teacher->save();
        $teacher->detail()->create([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);

        $teacher->courses()->attach($courses);

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
        $teacher = Teacher::find($id);
        $teacher->courses()->detach();
        $teacher->detail()->delete();
        $teacher->delete();

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
        $teacher = Teacher::findOrFail($id);
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
        $data = $request->all();
        $teacher = Teacher::findOrFail($data['id']);

        if (!Hash::check($data['oldPassword'], $teacher->password)) {

            return redirect()->back()->with(["error" => "Old Password Was Wrong"]);
        }
        Teacher::where('id', $request->id)->update(
            ['password' => Hash::make($request->newPassword)]
        );
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
        $result = Teacher::query()
            ->select('teacher.*', DB::raw('count(course_id) as total_courses'))
            ->leftJoin('teacher_course', 'teacher.id', '=', 'teacher_course.teacher_id')
            ->when($name, function ($q, $name) {
                $q->where('teacher_name', 'LIKE', '%' . $name . '%');
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
            ->groupBy('teacher.id')
            ->orderby('id')
            ->get();
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

        if (Auth::attempt($teacher)) {
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
        Auth::guard('teacher')->logout();

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
        // $id = session()->get('TEACHER_ID');
        // $teacher = Teacher::findOrFail($id);

        $teacher = Auth::user();
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
        $teacher = Auth::user();
        $courses = Course::all();
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

        unset($teacherData['courses']);

        $teacher = Auth::user();
        $teacher->update($teacherData);

        $teacher->detail()->update([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);
        $teacher->courses()->detach();
        $teacher->courses()->attach($courses);

        return redirect()->route('teacher.list');
    }

    /**
     * delete teacher
     *
     * @return void
     */
    public function profileDelete()
    {
        $teacher = Auth::user();
        $teacher->courses()->detach();
        $teacher->detail()->delete();
        $teacher->delete();

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

        $token = Str::random(64);

        DB::table('teacher_password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);
        Mail::send('teacher.forgetPasswordEmail', ['token' => $token], function ($message) use ($request) {
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

        $updatePassword = DB::table('teacher_password_resets')
            ->where('email', $request->email)
            ->first();

        if ($updatePassword && Hash::check($request->token, $updatePassword->token)) {

            Teacher::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('teacher_password_resets')->where('email', $request->email)->delete();
            return redirect()->route('teacher.login')->with('message', 'Your password has been changed!');
        }
        return back()->withInput()->with('error', 'Invalid token!');
    }
}
