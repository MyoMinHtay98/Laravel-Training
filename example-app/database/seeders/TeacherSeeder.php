<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\TeacherDetails;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::factory()->count(10)
            ->has(TeacherDetails::factory(), 'detail')
            ->create();
    }
}
