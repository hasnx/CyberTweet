<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrendingController extends Controller
{
    public function index()
    {
        $trending = Hashtag::orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        return Inertia::render('Trending/Index', [
            'trending' => $trending
        ]);
    }
}
