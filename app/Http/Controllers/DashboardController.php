<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'totalPosts' => $user->posts()->count(),
            'followers' => $user->followers()->count(),
            'trendingTags' => Hashtag::orderBy('posts_count', 'desc')->take(5)->count(),
            'onlineTime' => random_int(1, 24), // Mock data - implement real tracking if needed
        ];

        $recentPosts = $user->posts()
            ->with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($post) use ($user) {
                $post->liked = $post->likes()->where('user_id', $user->id)->exists();
                $post->reposted = $post->reposts()->where('user_id', $user->id)->exists();
                return $post;
            });

        $topHashtags = Hashtag::orderBy('posts_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($hashtag) {
                return [
                    'name' => $hashtag->name,
                    'count' => $hashtag->posts_count,
                ];
            });

        $recentFollowers = $user->followers()
            ->latest()
            ->take(6)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentPosts' => $recentPosts,
            'topHashtags' => $topHashtags,
            'recentFollowers' => $recentFollowers,
            'auth' => [
                'user' => $user
            ]
        ]);
    }
}
