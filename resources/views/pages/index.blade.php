<main class="flex-1">
    <ul class="space-y-8">
        @foreach ($posts as $post)
            <li class="space-y-2 leading-7">
                <h2 class="text-xl font-semibold">
                    <a class="hover:underline" href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                </h2>
                <div class="space-y-6">
                    {!! str($post->excerpt)->markdown() !!}
                </div>
            </li>
        @endforeach
    </ul>
    <section class="mt-10 lg:mt-20">
        <livewire:components.subscribe-box />
    </section>
</main>
