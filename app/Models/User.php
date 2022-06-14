<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbl_user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'gender',
        'phno',
        'is_admin',
        'age',
        'file_path',
        'address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // public function detail()
    // {
    //     return $this->hasOne(StudentDetails::class, 'student_id');
    // }

    // public function assignments()
    // {
    //     return $this->hasMany(Assignment::class, 'student_id');
    // }

    // public function courses()
    // {
    //     return $this->belongsToMany(Course::class, 'student_course', 'student_id', 'course_id');
    // }
}
