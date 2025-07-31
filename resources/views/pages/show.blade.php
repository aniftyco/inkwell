<x-slot:title>{{ $post->title }}</x-slot:title>
<x-slot:description>{{ $post->excerpt }}</x-slot:description>

<main class="flex-1">
    <article class="leading-7">
        <h1 class="text-xl font-semibold">{{ $post->title }}</h1>
        <ul class="flex py-4 text-xs sm:py-5 sm:text-base [&>li]:px-1 [&>li]:leading-4">
            <li>
                @if ($post->author->url)
                    <a class="hover:underline" href="{{ $post->author->url }}" rel="author noopener nofollow"
                        target="_blank">{{ $post->author->name }}</a>
                @else
                    <span>{{ $post->author->name }}</span>
                @endif
            </li>
            <li class="opacity-75">on</li>
            <li>{{ $post->published_at->format('F j, Y') }}</li>
        </ul>
        <div
            class="{{ clsx('prose prose-2xl space-y-6 [&>*]:text-base', 'prose-p:leading-6', 'prose-blockquote:border-accent') }}">
            {!! str($post->body)->markdown() !!}
        </div>
    </article>

    <section class="mt-10 lg:mt-20">
        <livewire:components.subscribe-box />
    </section>
</main>
