<?php

namespace Inkwell;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ServiceProvider extends PanelProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/views', 'inkwell');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadFactoriesFrom(__DIR__.'/database/factories');
    }

    public function panel(Panel $panel): Panel
    {
        return $panel->default()
            ->id('inkwell')
            ->path(config('inkwell.base', 'inkwell'))
            ->login()
            ->spa()
            ->unsavedChangesAlerts()
            ->brandName('Inkwell')
            ->brandLogo(fn () => view('inkwell::components.logo'))
            ->homeUrl(fn () => route('filament.inkwell.pages.dashboard'))
            ->colors(['primary' => Color::Slate, 'gray' => Color::Zinc])
            ->topNavigation()
            ->breadcrumbs(false)
            ->discoverResources(in: base_path('Inkwell/Resources'), for: 'Inkwell\\Resources')
            ->discoverPages(in: base_path('Inkwell/Pages'), for: 'Inkwell\\Pages')
            ->discoverWidgets(in: base_path('Inkwell/Widgets'), for: 'Inkwell\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
