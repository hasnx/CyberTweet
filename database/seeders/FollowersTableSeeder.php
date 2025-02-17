<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $users->each(function ($user) use ($users) {
            // Each user follows 5-15 random users
            $followings = $users->except($user->id)->random(rand(5, 15));
            $user->following()->attach($followings->pluck('id'));
        });
    }
}
