<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HashtagController extends Controller
{
    public function show($name)
    {
        $hashtag = Hashtag::where('name', $name)->firstOrFail();
        $posts = $hashtag->posts()
            ->with('user')
            ->latest()
            ->get()
            ->map(function ($post) {
                $post->liked = $post->likes()->where('user_id', auth()->id())->exists();
                $post->reposted = $post->reposts()->where('user_id', auth()->id())->exists();
                return $post;
            });

        return Inertia::render('Hashtag/Show', [
            'hashtag' => $hashtag,
            'posts' => $posts,
            'auth' => [
                'user' => auth()->user()
            ]
        ]);
    }
}
