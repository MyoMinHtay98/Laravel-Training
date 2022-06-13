<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
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
            'project_title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'duration' => mt_rand(20, 40),
            'date' => $this->faker->date(),
        ];
    }
}
