<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $posts = Post::with('user')
            ->latest()
            ->get()
            ->map(function ($post) use ($user) {
                $post->liked = $post->likes()->where('user_id', $user->id)->exists();
                $post->reposted = $post->reposts()->where('user_id', $user->id)->exists();
                return $post;
            });

        return Inertia::render('Feed', [
            'posts' => $posts,
            'auth' => [
                'user' => $user
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:280',
            'image_url' => 'nullable|url',
        ]);

        $post = $request->user()->posts()->create($validated);

        return redirect()->back();
    }

    public function like(Post $post)
    {
        $user = auth()->user();

        if (!$post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->create(['user_id' => $user->id]);
            $post->increment('likes_count');
        }

        return redirect()->back();
    }

    public function unlike(Post $post)
    {
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
            $post->decrement('likes_count');
        }

        return redirect()->back();
    }

    public function repost(Post $post)
    {
        $user = auth()->user();

        if (!$post->reposts()->where('user_id', $user->id)->exists()) {
            $post->reposts()->create(['user_id' => $user->id]);
            $post->increment('reposts_count');
        }

        return redirect()->back();
    }

    public function unrepost(Post $post)
    {
        $user = auth()->user();

        if ($post->reposts()->where('user_id', $user->id)->exists()) {
            $post->reposts()->where('user_id', $user->id)->delete();
            $post->decrement('reposts_count');
        }

        return redirect()->back();
    }
}
