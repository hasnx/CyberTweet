<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $cyberpunkPhrases = [
            'Just hacked into Arasaka\'s mainframe. The ICE was no match! #netrunner',
            'New chrome installed. Feeling more metal than meat now. #cyberpunk',
            'CyberTweet never sleeps, and neither do I. Time to hit the streets.',
            'Found a rare piece of tech in the Badlands. Ripper Doc says it\'s pre-war.',
            'Another day, another cyber-psycho taken down. The streets are safer now.',
            'Trading info at the Afterlife. The price of knowledge keeps going up.',
            'Got my hands on some black market software. Time to test it out.',
            'Corpo rats are up to something big. Time to investigate. #conspiracy',
            'Just upgraded my neural link. The dataflow is incredible! #tech',
            'Another day in CyberTweet, another chance to make it big or die trying.',
        ];

        return [
            'content' => $this->faker->randomElement($cyberpunkPhrases),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
}
