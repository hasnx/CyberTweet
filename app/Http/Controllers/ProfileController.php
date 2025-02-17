<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(User $username)
    {
        $currentUser = auth()->user();

        $stats = [
            'posts' => $username->posts()->count(),
            'following' => $username->following()->count(),
            'followers' => $username->followers()->count(),
        ];

        $posts = $username->posts()
            ->with('user')
            ->latest()
            ->get()
            ->map(function ($post) use ($currentUser) {
                $post->liked = $post->likes()->where('user_id', $currentUser->id)->exists();
                $post->reposted = $post->reposts()->where('user_id', $currentUser->id)->exists();
                return $post;
            });

        $likedPosts = $username->likes()
            ->with('post.user')
            ->latest()
            ->get()
            ->map(function ($like) use ($currentUser) {
                $post = $like->post;
                $post->liked = $post->likes()->where('user_id', $currentUser->id)->exists();
                $post->reposted = $post->reposts()->where('user_id', $currentUser->id)->exists();
                return $post;
            });

        $username->isFollowing = $currentUser->following()->where('following_id', $username->id)->exists();

        return Inertia::render('Profile/Show', [
            'user' => $username,
            'posts' => $posts,
            'likedPosts' => $likedPosts,
            'stats' => $stats,
            'auth' => [
                'user' => $currentUser
            ]
        ]);
    }

    public function follow(User $username)
    {
        auth()->user()->following()->attach($username->id);
        return redirect()->back();
    }

    public function unfollow(User $username)
    {
        auth()->user()->following()->detach($username->id);
        return redirect()->back();
    }
}
