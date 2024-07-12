<x-inkwell::layout class="mx-auto flex h-screen max-w-3xl flex-col gap-4 bg-zinc-50 py-12" title="Welcome to Inkwell!">
  <header class="pb-10 text-center">
    <h1 class="mb-2 text-5xl font-bold italic tracking-tight text-zinc-900">
      <a href="{{ route('posts.index') }}">{{ $post->title }}</a>
    </h1>
    <p class="text-zinc-700">Published {{ $post->published_at->format('F jS Y') }}</p>
  </header>

  <main class="flex flex-1 flex-col">
    <article class="prose min-w-full border-t-2 py-10">
      {!! str($post->body)->markdown() !!}
    </article>
  </main>

  <footer class="flex items-center justify-between border-t-2 py-10">
    <p class="text-sm text-zinc-600">© {{ date('Y') }} You</p>
    <p class="flex items-center gap-1 text-xs font-medium text-zinc-600">
      <span>Powered by</span>
      <a class="text-lg font-bold italic tracking-tight hover:underline"
        href="https://github.com/aniftyco/inkwell">Inkwell</a>
    </p>
  </footer>

</x-inkwell::layout>
