<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hashtag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'posts_count'
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'hashtag_post')
            ->withTimestamps();
    }
}
