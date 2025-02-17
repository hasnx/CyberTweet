<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HashtagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => strtolower($this->faker->unique()->word()),
            'posts_count' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
