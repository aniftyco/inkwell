<x-inkwell::layout title="Welcome to Inkwell!">
  <header class="pb-10 text-center">
    <h1 class="mb-2 text-5xl font-bold italic tracking-tight">
      <a href="{{ route('posts.index') }}">{{ $post->title }}</a>
    </h1>
    <p class="text-zinc-700 dark:text-zinc-400">Published {{ $post->published_at->format('F jS Y') }}</p>
  </header>

  <main class="flex flex-1 flex-col border-t-2 border-zinc-300 dark:border-zinc-500">
    <article class="prose dark:prose-invert prose-hr:border-zinc-300 dark:prose-hr:border-zinc-500 min-w-full py-10">
      {!! str($post->body)->markdown() !!}
    </article>
  </main>

  <footer class="flex items-center justify-between border-t-2 py-10 text-zinc-600 dark:text-zinc-200">
    <p class="text-sm">© {{ date('Y') }} You</p>
    <p class="flex items-center gap-1 text-xs font-medium">
      <span>Powered by</span>
      <a class="text-lg font-bold italic tracking-tight hover:underline"
        href="https://github.com/aniftyco/inkwell">Inkwell</a>
    </p>
  </footer>

</x-inkwell::layout>
