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
            ->get();

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
