<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $currentUser = auth()->user();

        $posts = Post::with('user')
            ->where('content', 'like', "%{$query}%")
            ->latest()
            ->get()
            ->map(function ($post) use ($currentUser) {
                $post->liked = $post->likes()->where('user_id', $currentUser->id)->exists();
                $post->reposted = $post->reposts()->where('user_id', $currentUser->id)->exists();
                return $post;
            });

        \Log::info('Search Results:', [
            'query' => $query,
            'posts_count' => $posts->count(),
            'posts' => $posts->toArray()
        ]);

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get()
            ->map(function ($user) use ($currentUser) {
                $user->isFollowing = $currentUser->following()->where('following_id', $user->id)->exists();
                return $user;
            });

        return Inertia::render('Search/Index', [
            'query' => $query,
            'posts' => $posts,
            'users' => $users,
            'auth' => [
                'user' => $currentUser
            ]
        ]);
    }
}
