<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'tbl_post';

    protected $fillable = [
        'title',
        'message',
        'is_public'
    ];

    // public function students()
    // {
    //     return $this->belongsToMany(Student::class, 'student_course', 'course_id', 'student_id');
    // }

    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class, 'teacher_id');
    // }

    // public function teachers()
    // {
    //     return $this->belongsToMany(Teacher::class, 'teacher_course', 'course_id', 'teacher_id');
    // }
}
