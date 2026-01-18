<?php

namespace NiftyCo\Inkwell;

use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use NiftyCo\Inkwell\Http\Middleware\CheckPermission;
use NiftyCo\Inkwell\Http\Middleware\ProcessPendingWork;
use NiftyCo\Inkwell\Support\AsyncDispatcher;
use NiftyCo\Inkwell\Support\MarkdownRenderer;
use NiftyCo\Inkwell\Support\PendingWork;
use NiftyCo\Inkwell\Support\ThemeManager;
use NiftyCo\Inkwell\View\Components\Subscribe;
use NiftyCo\Inkwell\View\Components\ThemeLayout;

class InkwellServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/inkwell.php', 'inkwell');

        // Register singletons
        $this->app->singleton(PendingWork::class);

        $this->app->singleton(AsyncDispatcher::class, function ($app) {
            return new AsyncDispatcher($app->make(PendingWork::class));
        });

        $this->app->singleton(ThemeManager::class);
        $this->app->singleton(MarkdownRenderer::class);

        $this->app->singleton(InkwellManager::class, function ($app) {
            return new InkwellManager($app->make(ThemeManager::class));
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'inkwell');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerMiddleware();
        $this->registerLivewireComponents();
        $this->registerBladeComponents();
        $this->registerThemeViewNamespace();
        $this->registerRoutes();
        $this->registerPublishing();
        $this->bootActiveTheme();
    }

    protected function bootActiveTheme(): void
    {
        $theme = $this->app->make(InkwellManager::class)->activeTheme();

        if ($theme) {
            $theme->boot();
        }
    }

    protected function registerMiddleware(): void
    {
        // Register route middleware alias
        $router = $this->app['router'];
        $router->aliasMiddleware('inkwell.permission', CheckPermission::class);

        // Register global terminable middleware
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(ProcessPendingWork::class);
    }

    protected function registerLivewireComponents(): void
    {
        // Register the Inkwell Livewire namespace as a component location
        // This allows Livewire to auto-discover and resolve components in NiftyCo\Inkwell\Livewire
        Livewire::addLocation(
            viewPath: __DIR__ . '/views/livewire',
            classNamespace: 'NiftyCo\\Inkwell\\Livewire'
        );
    }

    protected function registerRoutes(): void
    {
        $path = config('inkwell.dashboard.path', 'inkwell');

        Route::middleware('web')
            ->prefix($path)
            ->group(__DIR__ . '/routes/inkwell.php');
    }

    protected function registerBladeComponents(): void
    {
        Blade::component('inkwell::theme-layout', ThemeLayout::class);

        // Subscribe components
        Blade::component('inkwell::subscribe.form', Subscribe\Form::class);
        Blade::component('inkwell::subscribe.input', Subscribe\Input::class);
        Blade::component('inkwell::subscribe.name', Subscribe\Name::class);
        Blade::component('inkwell::subscribe.submit', Subscribe\Submit::class);
    }

    protected function registerThemeViewNamespace(): void
    {
        $themeManager = $this->app->make(ThemeManager::class);
        $theme = $themeManager->active();

        if ($theme) {
            $this->loadViewsFrom($theme->path . '/views', 'inkwell-theme');
        }
    }

    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish config
            $this->publishes([
                __DIR__ . '/../config/inkwell.php' => config_path('inkwell.php'),
            ], 'inkwell-config');

            // Publish migrations
            $this->publishes([
                __DIR__ . '/database/migrations' => database_path('migrations'),
            ], 'inkwell-migrations');

            // Publish views
            $this->publishes([
                __DIR__ . '/views' => resource_path('views/vendor/inkwell'),
            ], 'inkwell-views');
        }
    }
}
