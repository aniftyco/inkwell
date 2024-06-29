<?php

namespace NiftyCo\Inkwell;

use Filament\{Panel, Facades, Http, Support\Colors};
use Illuminate\{Cookie, Session, View, Foundation, Routing, Support};

class InkwellServiceProvider extends Support\ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'inkwell');
    }

    public function register(): void
    {
        Facades\Filament::registerPanel(function (): Panel {
            return Panel::make()
                ->default()
                ->id('inkwell')
                ->path('inkwell')
                ->brandName('Inkwell')
                ->brandLogo(fn () => view('inkwell::components.logo'))
                ->login()
                ->colors(fn () => [
                    'primary' => config('inkwell.colors.primary', Colors\Color::Pink),
                    'gray' => config('inkwell.colors.gray', Colors\Color::Zinc)
                ])
                ->topNavigation()
                ->discoverResources(in: base_path('Inkwell/src/Resources'), for: 'NiftyCo\\Inkwell\\Resources')
                ->discoverPages(in: base_path('Inkwell/src/Pages'), for: 'NiftyCo\\Inkwell\\Pages')
                ->discoverWidgets(in: base_path('Inkwell/src/Widgets'), for: 'NiftyCo\\Inkwell\\Widgets')
                ->middleware([
                    Cookie\Middleware\EncryptCookies::class,
                    Cookie\Middleware\AddQueuedCookiesToResponse::class,
                    Session\Middleware\StartSession::class,
                    Session\Middleware\AuthenticateSession::class,
                    View\Middleware\ShareErrorsFromSession::class,
                    Foundation\Http\Middleware\VerifyCsrfToken::class,
                    Routing\Middleware\SubstituteBindings::class,
                    Http\Middleware\DisableBladeIconComponents::class,
                    Http\Middleware\DispatchServingFilamentEvent::class,
                ])
                ->authMiddleware([
                    Http\Middleware\Authenticate::class,
                ])
            ;
        });
    }
}
