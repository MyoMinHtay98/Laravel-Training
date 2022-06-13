<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'teacher';

    protected $fillable = [
        'teacher_name',
        'email',
        'password',
        'nrc',
        'gender',
        'is_active',
        'dob',
        'age',
        'address'
    ];

    public function detail()
    {
        return $this->hasOne(TeacherDetails::class, 'teacher_id');
    }

    public function course()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'teacher_course', 'teacher_id', 'course_id');
    }
}
