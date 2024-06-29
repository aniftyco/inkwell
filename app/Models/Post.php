<?php

namespace App\Models;

use App\Enums\{PostAccess, PostStatus};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
        'access' => PostAccess::class,
        'status' => PostStatus::class,
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::PUBLISHED);
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', PostStatus::SCHEDULED);
    }

    public function scopeDrafts(Builder $query): Builder
    {
        return $query->where('status', PostStatus::DRAFT);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
