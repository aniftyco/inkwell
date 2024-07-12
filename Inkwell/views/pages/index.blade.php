<x-inkwell::layout title="Welcome to Inkwell!">
  <header class="pb-10 text-center">
    <h1 class="text-5xl font-bold italic tracking-tight">
      <a href="{{ route('posts.index') }}">Inkwell</a>
    </h1>
    <h2 class="text-2xl font-semibold">Your story, your canvas</h2>
  </header>

  <main class="flex flex-1 flex-col">
    @if (!$posts->isEmpty())
      @foreach ($posts as $post)
        <article class="border-t-2 border-zinc-300 py-10 dark:border-zinc-500">
          <h3 class="text-2xl font-semibold">
            <a
              class="hover:underline"
              href="{{ route('posts.show', $post->slug) }}"
              heref=""
            >{{ $post->title }}</a>
          </h3>
          <p class="leading-7">{{ $post->excerpt }}</p>
        </article>
      @endforeach

      {{ $posts->links('inkwell::components.pagination') }}
    @else
      <div class="text-center">
        <p class="mb-4 text-2xl">Blank canvas.</p>
        <p class="font-semibold italic text-pink-700 hover:underline">
          Go <a href="{{ route('filament.inkwell.resources.posts.index') }}">write your story</a>
        </p>

    @endif
  </main>

  <footer class="flex items-center justify-between border-t-2 border-zinc-300 py-10 dark:border-zinc-500">
    <p class="text-sm text-zinc-600">© {{ date('Y') }} You</p>
    <p class="flex items-center gap-1 text-xs font-medium text-zinc-600">
      <span>Powered by</span>
      <a class="text-lg font-bold italic tracking-tight hover:underline"
        href="https://github.com/aniftyco/inkwell">Inkwell</a>
    </p>
  </footer>

</x-inkwell::layout>
