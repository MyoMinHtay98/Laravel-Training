<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_name' => $this->faker->name,
            'email' => $this->faker->email(),
            'password' => bcrypt('12345678'),
            'gender' => $this->faker->randomElement(['m', 'f']),
            'is_active' => $this->faker->boolean(80),
            'dob' => $this->faker->date(),
            'age' => mt_rand(20, 40),
            'address' => $this->faker->address(),
        ];
    }
}
