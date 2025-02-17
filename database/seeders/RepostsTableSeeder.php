<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Repost;
use Illuminate\Database\Seeder;

class RepostsTableSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        $posts->each(function ($post) use ($users) {
            // Randomly select 0-5 users to repost each post
            $reposters = $users->random(rand(0, 5));

            $reposters->each(function ($user) use ($post) {
                Repost::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            });

            // Update reposts count
            $post->update(['reposts_count' => $post->reposts()->count()]);
        });
    }
}
