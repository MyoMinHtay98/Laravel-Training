<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_name' => $this->faker->name,
            'course_dt' => $this->faker->date(),
            'description' => $this->faker->realText($maxNbChars = 50, $indexSize = 2),
            'duration' => mt_rand(20, 40),
        ];
    }
}
