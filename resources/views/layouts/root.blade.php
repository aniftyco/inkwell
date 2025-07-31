<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/client/tailwind.css', 'resources/client/app.ts'])

    @livewireStyles
</head>

<body class="flex min-h-screen w-full max-w-5xl flex-col px-4 font-sans sm:pl-40">
    <header class="py-8">
        <h1 class="text-2xl font-semibold">
            @if (isset($title))
                <a href="{{ route('posts.index') }}">{{ config('app.name') }}</a>
            @else
                {{ config('app.name') }}
            @endif
        </h1>
    </header>

    {{ $slot }}

    <footer class="pb-8 pt-16 text-slate-600">
        <p class="text-xs -tracking-normal">Powered By <a class="font-sans text-sm font-semibold italic"
                href="https://github.com/aniftyco/inkwell" rel="noopener noreferrer" target="_blank">Inkwell</a></p>
    </footer>

    @livewireScriptConfig
</body>

</html>
