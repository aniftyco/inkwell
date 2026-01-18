<?php

namespace NiftyCo\Inkwell;

abstract class Theme
{
    /**
     * The theme's display name.
     * Required - must be set by extending class.
     */
    public string $name;

    /**
     * The theme's version.
     */
    public string $version;

    /**
     * The theme's author.
     */
    public string $author;

    /**
     * The theme's description.
     */
    public string $description;

    /**
     * The theme's slug (directory name).
     * Set automatically during discovery.
     */
    public string $slug;

    /**
     * The theme's path.
     * Set automatically during discovery.
     */
    public string $path;

    /**
     * Register theme-specific routes.
     */
    public function routes(): void
    {
        //
    }

    /**
     * Boot the theme.
     */
    public function boot(): void
    {
        //
    }
}
