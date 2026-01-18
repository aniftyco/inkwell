<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reply extends Model
{
    protected $fillable = [
        'post_id',
        'reply_type',
        'reply_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function repliable(): MorphTo
    {
        return $this->morphTo('reply', 'reply_type', 'reply_id');
    }

    public static function createFromEmailReply(Post $post, EmailReply $emailReply): self
    {
        return static::create([
            'post_id' => $post->id,
            'reply_type' => EmailReply::class,
            'reply_id' => $emailReply->id,
        ]);
    }
}
