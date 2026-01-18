<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Segment extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'tag_ids',
    ];

    protected $casts = [
        'tag_ids' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Segment $segment) {
            if (empty($segment->slug)) {
                $segment->slug = Str::slug($segment->name);
            }
        });
    }

    public function subscribers(): Builder
    {
        if (empty($this->tag_ids)) {
            return Subscriber::query();
        }

        return Subscriber::whereHas('tags', function ($query) {
            $query->whereIn('tags.id', $this->tag_ids);
        });
    }

    public function getSubscriberCount(): int
    {
        return $this->subscribers()->confirmed()->count();
    }

    public function tags()
    {
        return Tag::whereIn('id', $this->tag_ids ?? [])->get();
    }
}
