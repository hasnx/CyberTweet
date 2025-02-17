<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user first
        $this->call(AdminUserSeeder::class);

        // Create hashtags before posts
        $this->call(HashtagsTableSeeder::class);

        // Create regular users
        User::factory(10)->create();

        // Create posts with hashtags
        $this->call(PostsTableSeeder::class);

        // Create followers
        User::all()->each(function ($user) {
            // Each user follows 1-5 random users
            $followCount = random_int(1, 5);
            $followIds = User::where('id', '!=', $user->id)
                ->inRandomOrder()
                ->limit($followCount)
                ->pluck('id');

            $user->following()->attach($followIds);
        });

        // Create likes and reposts
        $this->call([
            LikesTableSeeder::class,
            RepostsTableSeeder::class,
        ]);

        // Update hashtag counts
        $this->call(UpdateHashtagCountsSeeder::class);
    }
}
