<?php

namespace NiftyCo\Inkwell\Support;

use Illuminate\Support\Facades\File;
use NiftyCo\Inkwell\Theme;

class ThemeManager
{
    protected ?array $themes = null;

    public function getThemesPath(): string
    {
        return config('inkwell.themes.path', base_path('themes'));
    }

    public function discover(): array
    {
        if ($this->themes !== null) {
            return $this->themes;
        }

        $this->themes = [];
        $themesPath = $this->getThemesPath();

        if (! File::isDirectory($themesPath)) {
            return $this->themes;
        }

        $directories = File::directories($themesPath);

        foreach ($directories as $directory) {
            $themeFile = $directory . '/Theme.php';

            if (File::exists($themeFile)) {
                $theme = $this->resolveTheme($directory);

                if ($theme) {
                    $this->themes[$theme->slug] = $theme;
                }
            }
        }

        return $this->themes;
    }

    protected function resolveTheme(string $directory): ?Theme
    {
        $themeFile = $directory . '/Theme.php';

        $theme = require $themeFile;

        if ($theme instanceof Theme) {
            $theme->slug = basename($directory);
            $theme->path = $directory;

            return $theme;
        }

        return null;
    }

    public function all(): array
    {
        return $this->discover();
    }

    public function get(string $slug): ?Theme
    {
        $themes = $this->discover();

        return $themes[$slug] ?? null;
    }

    public function exists(string $slug): bool
    {
        return $this->get($slug) !== null;
    }

    public function active(): ?Theme
    {
        $activeSlug = Settings::get('active_theme', 'default');

        return $this->get($activeSlug);
    }

    public function activeSlug(): string
    {
        return Settings::get('active_theme', 'default');
    }

    public function setActive(string $slug): bool
    {
        if (! $this->exists($slug)) {
            return false;
        }

        Settings::set('active_theme', $slug);

        return true;
    }

    public function getViewPath(string $view): ?string
    {
        $active = $this->active();

        if ($active) {
            $themePath = $active->path . '/views/' . str_replace('.', '/', $view) . '.blade.php';

            if (File::exists($themePath)) {
                return $themePath;
            }
        }

        return null;
    }

    public function hasView(string $view): bool
    {
        return $this->getViewPath($view) !== null;
    }

    public function getAssetPath(string $asset): ?string
    {
        $active = $this->active();

        if ($active) {
            $assetPath = $active->path . '/assets/' . $asset;

            if (File::exists($assetPath)) {
                return $assetPath;
            }
        }

        return null;
    }

    public function getAssetUrl(string $asset): ?string
    {
        $path = $this->getAssetPath($asset);

        if ($path) {
            $relativePath = str_replace(base_path() . '/', '', $path);

            return asset($relativePath);
        }

        return null;
    }

    public function clearCache(): void
    {
        $this->themes = null;
    }
}
