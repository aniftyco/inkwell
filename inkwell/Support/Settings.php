<?php

namespace NiftyCo\Inkwell\Support;

use Illuminate\Support\Facades\Cache;
use NiftyCo\Inkwell\Models\Setting;

class Settings
{
    protected static ?array $cache = null;

    protected static array $defaults = [
        'active_theme' => 'default',
        'site_name' => 'My Blog',
        'site_description' => '',
        'posts_per_page' => 10,
        'allow_comments' => true,
        'require_confirmation' => true,
    ];

    public static function defaults(): array
    {
        return static::$defaults;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::all();

        return $all[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        static::clearCache();
    }

    public static function has(string $key): bool
    {
        return array_key_exists($key, static::all());
    }

    public static function all(): array
    {
        if (static::$cache !== null) {
            return static::$cache;
        }

        $dbSettings = static::loadFromDatabase();

        static::$cache = array_merge(static::$defaults, $dbSettings);

        return static::$cache;
    }

    public static function save(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        static::clearCache();
    }

    public static function saveAll(): void
    {
        static::save(static::all());
    }

    protected static function loadFromDatabase(): array
    {
        try {
            return Setting::all()
                ->pluck('value', 'key')
                ->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function clearCache(): void
    {
        static::$cache = null;
    }

    public static function registerDefault(string $key, mixed $value): void
    {
        static::$defaults[$key] = $value;
        static::clearCache();
    }

    public static function registerDefaults(array $defaults): void
    {
        static::$defaults = array_merge(static::$defaults, $defaults);
        static::clearCache();
    }
}
