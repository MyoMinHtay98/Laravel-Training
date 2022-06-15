<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Services\AuthService;
use App\Services\TeacherService;
use App\Services\StudentService;

class UserController extends Controller
{

    public function __construct()
    {
       
    }

     /**
     * show create page
     *
     * @return void
     */
    public function showCreate()
    {
        $user = $this->userService->getUsers();

        return view('user.register', compact('user'));
    }

    /**
     * create student
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $userData = $request->validate([
            'name' => 'required|max:50',
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

   
}
