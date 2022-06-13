<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Assignment;
use App\Models\StudentDetails;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::factory()->count(10)
            ->has(Assignment::factory()->count(10), 'assignments')
            ->has(StudentDetails::factory(), 'detail')
            ->create();
    }
}
