<?php

namespace NiftyCo\Inkwell\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (Permission $permission) {
            if (empty($permission->slug)) {
                $permission->slug = Str::slug($permission->name, '.');
            }
        });
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    public static function findOrCreateBySlug(string $slug, ?string $name = null): self
    {
        return static::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name ?? Str::title(str_replace('.', ' ', $slug))]
        );
    }
}
