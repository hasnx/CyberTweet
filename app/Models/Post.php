<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'image_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function reposts(): HasMany
    {
        return $this->hasMany(Repost::class);
    }

    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class, 'hashtag_post')
            ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $hashtags = [];
            preg_match_all('/#(\w+)/', $post->content, $matches);

            foreach ($matches[1] as $name) {
                $hashtag = Hashtag::firstOrCreate(
                    ['name' => Str::lower($name)],
                    ['posts_count' => 0]
                );
                $hashtags[] = $hashtag->id;
                $hashtag->increment('posts_count');
            }

            if (!empty($hashtags)) {
                $post->hashtags()->attach($hashtags);
            }
        });

        static::deleting(function ($post) {
            $post->hashtags->each(function ($hashtag) {
                $hashtag->decrement('posts_count');
            });
        });
    }
}
