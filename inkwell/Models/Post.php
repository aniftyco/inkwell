<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use NiftyCo\Inkwell\Enums\PostVisibility;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'visibility',
        'published_at',
    ];

    protected $casts = [
        'visibility' => PostVisibility::class,
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function campaign(): HasOne
    {
        return $this->hasOne(Campaign::class)->latestOfMany();
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function isPublished(): bool
    {
        return $this->visibility->isPublished() && $this->published_at !== null;
    }

    public function isDraft(): bool
    {
        return $this->visibility === PostVisibility::Draft;
    }

    public function isPubliclyVisible(): bool
    {
        return $this->visibility->isPubliclyVisible() && $this->isPublished();
    }

    public function isSubscribersOnly(): bool
    {
        return $this->visibility === PostVisibility::Subscribers;
    }

    public function publish(): self
    {
        if ($this->visibility === PostVisibility::Draft) {
            $this->visibility = PostVisibility::Public;
        }

        $this->published_at = $this->published_at ?? now();
        $this->save();

        return $this;
    }

    public function scopePublished($query)
    {
        return $query
            ->where('visibility', '!=', PostVisibility::Draft)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopePublic($query)
    {
        return $query
            ->where('visibility', PostVisibility::Public)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('visibility', PostVisibility::Draft);
    }

    public function scopeScheduled($query)
    {
        return $query
            ->where('visibility', '!=', PostVisibility::Draft)
            ->whereNotNull('published_at')
            ->where('published_at', '>', now());
    }

    protected static function newFactory()
    {
        return \NiftyCo\Inkwell\Database\Factories\PostFactory::new();
    }
}
