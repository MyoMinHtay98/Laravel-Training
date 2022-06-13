<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignment';

    protected $fillable = [
        'student_id',
        'project_title',
        'duration',
        'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

}
