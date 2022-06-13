<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_id' => $this->faker->boolean(50),
            'mother_name' => $this->faker->name,
            'father_name' => $this->faker->name,
            'hobby' => $this->faker->realText($maxNbChars = 50, $indexSize = 2),
        ];
    }
}
