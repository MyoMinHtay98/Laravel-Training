<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'teacher_name' => $this->faker->name,
            'email' => $this->faker->email(),
            'password' => bcrypt('12345678'),
            'nrc' => '121333535',
            'gender' => $this->faker->randomElement(['m', 'f']),
            'is_active' => $this->faker->boolean(80),
            'dob' => $this->faker->date(),
            'age' => mt_rand(20, 40),
            'address' => $this->faker->address(),
        ];
    }
}
