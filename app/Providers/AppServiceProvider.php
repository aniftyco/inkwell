<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Date::use(CarbonImmutable::class);
        URL::forceScheme('https');
        JsonResource::withoutWrapping();
        Model::automaticallyEagerLoadRelationships();
        Vite::useBuildDirectory(null);
        Vite::useManifestFilename('assets/manifest.json');
        Vite::useAggressivePrefetching();
    }
}
