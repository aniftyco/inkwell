<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Home' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
  </head>

  <body {{ $attributes->except('title') }}>
    {{ $slot }}
  </body>

</html>
