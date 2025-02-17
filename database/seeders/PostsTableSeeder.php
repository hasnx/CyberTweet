<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Hashtag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    public function run(): void
    {
        $hashtags = Hashtag::all();
        $users = User::all();

        $cyberpunkPhrases = [
            'Just hacked into Arasaka\'s mainframe. The ICE was no match! #netrunner',
            'New chrome installed. Feeling more metal than meat now. #cyberpunk',
            'CyberTweet never sleeps, and neither do I. Time to hit the streets. #nightcity',
            'Found a rare piece of tech in the Badlands. Ripper Doc says it\'s pre-war. #tech',
            'Another day, another cyber-psycho taken down. The streets are safer now. #streetkid',
            'Trading info at the Afterlife. The price of knowledge keeps going up. #afterlife',
            'Got my hands on some black market software. Time to test it out. #hack',
            'Corpo rats are up to something big. Time to investigate. #conspiracy #corpo',
            'Just upgraded my neural link. The dataflow is incredible! #tech #chrome',
            'Another day in CyberTweet, another chance to make it big or die trying. #edgerunner',
        ];

        foreach ($users as $user) {
            // Create 3-7 posts for each user
            $postCount = random_int(3, 7);
            for ($i = 0; $i < $postCount; $i++) {
                $post = Post::create([
                    'user_id' => $user->id,
                    'content' => $cyberpunkPhrases[array_rand($cyberpunkPhrases)],
                    'created_at' => now()->subDays(random_int(0, 30))->subHours(random_int(0, 24)),
                ]);

                // Extract hashtags from content and associate them with the post
                preg_match_all('/#(\w+)/', $post->content, $matches);
                if (!empty($matches[1])) {
                    // Get unique hashtags only
                    $uniqueHashtags = array_unique($matches[1]);
                    $postHashtags = Hashtag::whereIn('name', $uniqueHashtags)->get();

                    // Use sync instead of attach to prevent duplicates
                    $post->hashtags()->sync($postHashtags->pluck('id'));
                }
            }
        }
    }
}
