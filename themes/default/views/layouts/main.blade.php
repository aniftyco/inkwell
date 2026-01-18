<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        * { margin: 0; }
        html { -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', system-ui, sans-serif; line-height: 1.6; color: #1a1a1a; background: #fafafa; }
        a { color: #2563eb; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .container { max-width: 680px; margin: 0 auto; padding: 0 1.5rem; }
        header { padding: 2rem 0; border-bottom: 1px solid #e5e5e5; background: #fff; }
        header .container { display: flex; align-items: center; justify-content: space-between; }
        .site-title { font-size: 1.25rem; font-weight: 600; color: #1a1a1a; }
        .site-title:hover { text-decoration: none; }
        nav a { margin-left: 1.5rem; font-size: 0.875rem; color: #666; }
        main { padding: 3rem 0; min-height: calc(100vh - 200px); }
        footer { padding: 2rem 0; border-top: 1px solid #e5e5e5; background: #fff; }
        footer .container { text-align: center; font-size: 0.875rem; color: #666; }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <div class="container">
            <a href="{{ url('/') }}" class="site-title">
                {{ \NiftyCo\Inkwell\Support\Settings::get('site_name', config('app.name')) }}
            </a>
            <nav>
                <a href="{{ url('/') }}">Posts</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            @yield('body')
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ \NiftyCo\Inkwell\Support\Settings::get('site_name', config('app.name')) }}</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
