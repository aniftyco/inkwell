<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use NiftyCo\Inkwell\Enums\CampaignStatus;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'subject',
        'body',
        'template',
        'status',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'status' => CampaignStatus::class,
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    public function getRecipientCount(): int
    {
        return $this->emails()->count();
    }

    public function getSentCount(): int
    {
        return $this->emails()->where('status', 'sent')->orWhere('status', 'delivered')->count();
    }

    public function getFailedCount(): int
    {
        return $this->emails()->whereIn('status', ['bounced', 'complained', 'failed'])->count();
    }

    public function canEdit(): bool
    {
        return $this->status->canEdit();
    }

    public function canSend(): bool
    {
        return $this->status->canSend();
    }

    public function scopeDraft($query)
    {
        return $query->where('status', CampaignStatus::Draft);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', CampaignStatus::Scheduled);
    }

    public function scopeSent($query)
    {
        return $query->where('status', CampaignStatus::Sent);
    }

    public function scopeReadyToSend($query)
    {
        return $query
            ->where('status', CampaignStatus::Scheduled)
            ->where('scheduled_at', '<=', now());
    }

    protected static function newFactory()
    {
        return \NiftyCo\Inkwell\Database\Factories\CampaignFactory::new();
    }
}
