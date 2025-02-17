<?php

namespace Database\Seeders;

use App\Models\Hashtag;
use Illuminate\Database\Seeder;

class UpdateHashtagCountsSeeder extends Seeder
{
    public function run(): void
    {
        Hashtag::all()->each(function ($hashtag) {
            $hashtag->update([
                'posts_count' => $hashtag->posts()->count()
            ]);
        });
    }
}
