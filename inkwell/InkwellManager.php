<?php

namespace NiftyCo\Inkwell;

use Illuminate\Support\Facades\Route;
use NiftyCo\Inkwell\Exceptions\NoActiveThemeException;
use NiftyCo\Inkwell\Support\ThemeManager;

class InkwellManager
{
    protected bool $routesRegistered = false;

    public function __construct(
        protected ThemeManager $themeManager
    ) {}

    /**
     * Register the default theme routes.
     * Called from routes/web.php: Inkwell::routes()
     */
    public function routes(array $attributes = []): void
    {
        if ($this->routesRegistered) {
            return;
        }

        $attributes = array_merge(['middleware' => ['web']], $attributes);

        Route::group($attributes, function () {
            $this->registerThemeRoutes();
            $this->registerDefaultRoutes();
        });

        $this->routesRegistered = true;
    }

    protected function registerDefaultRoutes(): void
    {
        Route::get('/', \NiftyCo\Inkwell\Http\Controllers\IndexController::class)
            ->name('inkwell.index');

        // Use {slug} not {post:slug} so we can handle 404 with theme's view
        Route::get('/{slug}', \NiftyCo\Inkwell\Http\Controllers\PostController::class)
            ->name('inkwell.post');
    }

    protected function registerThemeRoutes(): void
    {
        $this->activeTheme()->routes();
    }

    public function themes(): ThemeManager
    {
        return $this->themeManager;
    }

    public function activeTheme(): Theme
    {
        $theme = $this->themeManager->active();

        if (! $theme) {
            throw new NoActiveThemeException;
        }

        return $theme;
    }
}
