<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
    ];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class)->withTimestamps();
    }

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class);
    }

    public static function findOrCreateBySlug(string $slug): self
    {
        $slug = Str::slug($slug);

        return static::withTrashed()->firstOrCreate(['slug' => $slug]);
    }

    public static function findOrCreateManySlugs(array $slugs): array
    {
        return collect($slugs)
            ->map(fn ($slug) => static::findOrCreateBySlug($slug))
            ->all();
    }
}
