<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class EmailReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'subject',
        'body',
        'message_id',
        'in_reply_to',
        'references',
        'headers',
    ];

    protected $casts = [
        'headers' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (EmailReply $emailReply) {
            if (empty($emailReply->message_id)) {
                $emailReply->message_id = static::generateMessageId();
            }
        });
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function reply(): MorphOne
    {
        return $this->morphOne(Reply::class, 'reply', 'reply_type', 'reply_id');
    }

    public static function generateMessageId(): string
    {
        $domain = parse_url(config('app.url'), PHP_URL_HOST) ?? 'inkwell.local';

        return '<' . Str::uuid() . '@' . $domain . '>';
    }

    public function buildReferences(string $parentMessageId): string
    {
        $references = $this->references ? trim($this->references) . ' ' : '';

        return $references . $parentMessageId;
    }

    public function getThreadChain(): array
    {
        if (empty($this->references)) {
            return [$this->in_reply_to];
        }

        $refs = preg_split('/\s+/', trim($this->references));

        return array_filter($refs);
    }

    public static function findByInReplyTo(string $messageId): ?Email
    {
        return Email::where('message_id', $messageId)->first();
    }

    protected static function newFactory()
    {
        return \NiftyCo\Inkwell\Database\Factories\EmailReplyFactory::new();
    }
}
