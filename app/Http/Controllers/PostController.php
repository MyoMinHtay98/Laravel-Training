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
   
}
