<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherDetails extends Model
{
    use HasFactory;

    protected $table = 'teacher_details';

    public $timestamps = false;

    protected $fillable = [
        'teacher_id',
        'mother_name',
        'father_name',
        'hobby'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
