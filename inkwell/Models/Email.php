<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use NiftyCo\Inkwell\Enums\EmailStatus;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'subscriber_id',
        'message_id',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'status' => EmailStatus::class,
        'sent_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Email $email) {
            if (empty($email->message_id)) {
                $email->message_id = static::generateMessageId();
            }
        });
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    public static function generateMessageId(): string
    {
        $domain = parse_url(config('app.url'), PHP_URL_HOST) ?? 'inkwell.local';

        return '<' . Str::uuid() . '@' . $domain . '>';
    }

    public function markAsSent(): self
    {
        $this->update([
            'status' => EmailStatus::Sent,
            'sent_at' => now(),
        ]);

        return $this;
    }

    public function markAsDelivered(): self
    {
        $this->update(['status' => EmailStatus::Delivered]);

        return $this;
    }

    public function markAsBounced(): self
    {
        $this->update(['status' => EmailStatus::Bounced]);

        return $this;
    }

    public function markAsComplained(): self
    {
        $this->update(['status' => EmailStatus::Complained]);

        return $this;
    }

    public function markAsFailed(): self
    {
        $this->update(['status' => EmailStatus::Failed]);

        return $this;
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', [EmailStatus::Queued, EmailStatus::Sending]);
    }

    public function scopeSuccessful($query)
    {
        return $query->whereIn('status', [EmailStatus::Sent, EmailStatus::Delivered]);
    }

    public function scopeFailed($query)
    {
        return $query->whereIn('status', [EmailStatus::Bounced, EmailStatus::Complained, EmailStatus::Failed]);
    }

    protected static function newFactory()
    {
        return \NiftyCo\Inkwell\Database\Factories\EmailFactory::new();
    }
}
