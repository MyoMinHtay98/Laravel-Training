<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetails extends Model
{
    use HasFactory;

    protected $table = 'student_details';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'mother_name',
        'father_name',
        'hobby'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
