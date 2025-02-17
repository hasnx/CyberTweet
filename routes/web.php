<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HashtagController;
use App\Http\Controllers\UsernameController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/', [PostController::class, 'index'])->name('feed');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/like', [PostController::class, 'unlike'])->name('posts.unlike');
    Route::post('/posts/{post}/repost', [PostController::class, 'repost'])->name('posts.repost');
    Route::delete('/posts/{post}/repost', [PostController::class, 'unrepost'])->name('posts.unrepost');
    Route::get('/@{username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/@{username}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::delete('/@{username}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/hashtag/{name}', [HashtagController::class, 'show'])->name('hashtag.show');
    Route::post('/username/check', [UsernameController::class, 'check'])
        ->name('username.check')
        ->middleware('auth');
});
