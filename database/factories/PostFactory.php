<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $this->faker->realText($maxNbChars = 50, $indexSize = 2),
        ];
    }
}
