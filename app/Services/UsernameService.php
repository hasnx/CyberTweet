<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UsernameService
{
    protected $reservedUsernames = [
        'admin',
        'root',
        'system',
        'support',
        'help',
        'info',
        'contact',
        'about',
        'terms',
        'privacy',
        'security',
        'api',
        'oauth',
        'auth',
        'login',
        'logout',
        'register',
        'settings',
        'profile',
        'dashboard'
    ];

    public function generateUsername(string $name): string
    {
        // Convert name to username format
        $baseUsername = Str::lower(preg_replace('/[^a-zA-Z0-9]/', '', $name));

        if (strlen($baseUsername) < 3) {
            $baseUsername = 'user' . $baseUsername;
        }

        $username = $baseUsername;
        $counter = 1;

        // Keep trying until we find an available username
        while (!$this->isUsernameAvailable($username)) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function isUsernameAvailable(string $username): bool
    {
        if (in_array(Str::lower($username), $this->reservedUsernames)) {
            return false;
        }

        return !User::where('username', $username)->exists();
    }

    public function validateUsername(string $username): array
    {
        $errors = [];

        if (strlen($username) < 3 || strlen($username) > 30) {
            $errors[] = 'Username must be between 3 and 30 characters.';
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $username)) {
            $errors[] = 'Username must start with a letter and can only contain letters, numbers, and underscores.';
        }

        if (in_array(Str::lower($username), $this->reservedUsernames)) {
            $errors[] = 'This username is reserved.';
        }

        return $errors;
    }
}
