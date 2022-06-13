<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'student';

    protected $fillable = [
        'student_name',
        'email',
        'password',
        'gender',
        'is_active',
        'dob',
        'age',
        "file_path",
        'address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function detail()
    {
        return $this->hasOne(StudentDetails::class, 'student_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'student_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course', 'student_id', 'course_id');
    }
}
