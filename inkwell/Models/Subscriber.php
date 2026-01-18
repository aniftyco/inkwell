<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'name',
        'metadata',
        'notes',
        'confirmed_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'confirmed_at' => 'datetime',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    public function emailReplies(): HasMany
    {
        return $this->hasMany(EmailReply::class);
    }

    public function user(): ?\App\Models\User
    {
        return \App\Models\User::where('email', $this->email)->first();
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed_at !== null;
    }

    public function isPending(): bool
    {
        return $this->confirmed_at === null;
    }

    public function isUnsubscribed(): bool
    {
        return $this->trashed();
    }

    public function confirm(): self
    {
        $this->update(['confirmed_at' => now()]);

        return $this;
    }

    public function scopeConfirmed($query)
    {
        return $query->whereNotNull('confirmed_at');
    }

    public function scopePending($query)
    {
        return $query->whereNull('confirmed_at');
    }

    public function scopeWithTags($query, array $tagIds)
    {
        return $query->whereHas('tags', function ($q) use ($tagIds) {
            $q->whereIn('tags.id', $tagIds);
        });
    }

    protected static function newFactory()
    {
        return \NiftyCo\Inkwell\Database\Factories\SubscriberFactory::new();
    }
}
