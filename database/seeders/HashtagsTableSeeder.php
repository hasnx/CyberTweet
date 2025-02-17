<?php

namespace Database\Seeders;

use App\Models\Hashtag;
use Illuminate\Database\Seeder;

class HashtagsTableSeeder extends Seeder
{
    public function run(): void
    {
        $hashtags = [
            'cyberpunk',
            'nightcity',
            'netrunner',
            'chrome',
            'hack',
            'cyberware',
            'edgerunner',
            'corpo',
            'streetkid',
            'nomad',
            'tech',
            'conspiracy',
            'arasaka',
            'badlands',
            'afterlife'
        ];

        foreach ($hashtags as $tag) {
            Hashtag::firstOrCreate(
                ['name' => $tag],
                ['posts_count' => 0]
            );
        }
    }
}
