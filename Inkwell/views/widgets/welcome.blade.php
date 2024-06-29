@php
  $user = filament()->auth()->user();
  $now = now();

  $greeting = 'Good morning';

  if ($now->hour >= 12 && $now->hour < 18) {
      $greeting = 'Good afternoon';
  } elseif ($now->hour >= 18) {
      $greeting = 'Good evening';
  }

@endphp

<x-filament-widgets::widget class="fi-account-widget">
  <x-filament::section>
    <div class="flex items-center gap-x-3">
      <x-filament-panels::avatar.user size="lg" :user="$user" />

      <div class="flex-1">
        <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">
          {{ $greeting }}!
        </h2>

        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ filament()->getUserName($user) }}
        </p>
      </div>
    </div>
  </x-filament::section>
</x-filament-widgets::widget>
