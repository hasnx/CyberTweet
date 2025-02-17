<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        $posts->each(function ($post) use ($users) {
            // Randomly select 0-10 users to like each post
            $likers = $users->random(rand(0, 10));

            $likers->each(function ($user) use ($post) {
                Like::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            });

            // Update likes count
            $post->update(['likes_count' => $post->likes()->count()]);
        });
    }
}
