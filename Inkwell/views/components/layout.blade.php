<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Home' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
  </head>

  <body
    {{ $attributes->except('title')->merge([
        'class' =>
            'mx-auto flex h-screen max-w-3xl flex-col gap-4 bg-zinc-50 dark:bg-zinc-950 py-12 text-zinc-900 dark:text-zinc-50',
    ]) }}
  >
    {{ $slot }}
  </body>

</html>
