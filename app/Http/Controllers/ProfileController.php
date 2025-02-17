<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $stats = [
            'posts_count' => $user->posts()->count(),
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
        ];

        $isFollowing = auth()->user()->following()->where('following_id', $user->id)->exists();

        return Inertia::render('Profile/CyberProfile', [
            'user' => $user,
            'posts' => $user->posts()->with('user')->latest()->get(),
            'stats' => $stats,
            'isFollowing' => $isFollowing,
            'auth' => [
                'user' => auth()->user()
            ]
        ]);
    }

    public function follow(User $user)
    {
        auth()->user()->following()->attach($user->id);
        return redirect()->back();
    }

    public function unfollow(User $user)
    {
        auth()->user()->following()->detach($user->id);
        return redirect()->back();
    }
}
