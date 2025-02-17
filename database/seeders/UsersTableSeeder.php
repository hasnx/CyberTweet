<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create main test user
        $mainUser = User::factory()->create([
            'name' => 'V',
            'email' => 'v@nightcity.net',
            'password' => bcrypt('password'),
        ]);

        // Create other users
        User::factory(20)->create();
    }
}
