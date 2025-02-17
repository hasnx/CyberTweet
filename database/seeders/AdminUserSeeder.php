<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'username' => 'sysadmin',
            'email' => 'admin@nightcity.net',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
}
