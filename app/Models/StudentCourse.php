<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;

    protected $table = 'student_course';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'course_id'
    ];
}
