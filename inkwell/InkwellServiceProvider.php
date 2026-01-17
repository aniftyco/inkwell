<?php

namespace NiftyCo\Inkwell;

use Illuminate\Support\ServiceProvider;

class InkwellServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/views', 'inkwell');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadFactoriesFrom(__DIR__.'/database/factories');
    }
}
