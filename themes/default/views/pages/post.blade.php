@extends('inkwell-theme::layouts.main', ['title' => $post->title])

@section('body')
    <article>
        <header style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; line-height: 1.3;">
                {{ $post->title }}
            </h1>
            <div style="font-size: 0.875rem; color: #666;">
                <time datetime="{{ $post->published_at->toISOString() }}">
                    {{ $post->published_at->format('F j, Y') }}
                </time>
                @if($post->user)
                    <span style="margin: 0 0.5rem;">&middot;</span>
                    <span>{{ $post->user->name }}</span>
                @endif
            </div>
        </header>

        <div class="prose" style="font-size: 1.125rem; line-height: 1.8;">
            {!! $content !!}
        </div>

        <footer style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e5e5e5;">
            <x-inkwell::subscribe.form class="flex gap-2 mb-4">
                <x-inkwell::subscribe.input class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                <x-inkwell::subscribe.submit class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 whitespace-nowrap">
                    Subscribe
                </x-inkwell::subscribe.submit>
            </x-inkwell::subscribe.form>
            <x-inkwell::subscribe.errors />

            <div style="margin-top: 2rem;">
                <a href="{{ route('inkwell.index') }}" style="font-size: 0.875rem;">&larr; Back to all posts</a>
            </div>
        </footer>
    </article>

    @push('styles')
    <style>
        .prose h2 { font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem; }
        .prose h3 { font-size: 1.25rem; font-weight: 600; margin: 1.5rem 0 0.75rem; }
        .prose p { margin-bottom: 1.25rem; }
        .prose ul, .prose ol { margin: 1.25rem 0; padding-left: 1.5rem; }
        .prose li { margin-bottom: 0.5rem; }
        .prose blockquote { border-left: 3px solid #e5e5e5; padding-left: 1rem; margin: 1.5rem 0; color: #666; font-style: italic; }
        .prose pre { background: #1a1a1a; color: #fff; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; margin: 1.5rem 0; }
        .prose code { font-family: 'SF Mono', Monaco, monospace; font-size: 0.875em; }
        .prose p code { background: #f0f0f0; padding: 0.125rem 0.375rem; border-radius: 0.25rem; }
        .prose img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1.5rem 0; }
        .prose a { color: #2563eb; text-decoration: underline; }
    </style>
    @endpush
@endsection
