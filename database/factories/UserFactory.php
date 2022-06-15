<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'mother_name' => $this->faker->name,
            'father_name' => $this->faker->name,
            'email' => $this->faker->email(),
            'password' => bcrypt('12345678'),
            'gender' => $this->faker->randomElement(['m', 'f']),
            'is_admin' => $this->faker->boolean(80),
            'dob' => $this->faker->date(),
            'age' => mt_rand(20, 40),
            'hobby' => $this->faker->realText($maxNbChars = 50, $indexSize = 2),
            'address' => $this->faker->address(),
        ];
    }
}
