@extends('inkwell-theme::layouts.main')

@section('body')
    @if($description = \NiftyCo\Inkwell\Support\Settings::get('site_description'))
        <p style="margin-bottom: 2rem; color: #666;">{{ $description }}</p>
    @endif

    <div style="margin-bottom: 3rem;">
        <x-inkwell::subscribe.form class="space-y-2">
            <div x-show="success" class="p-4 bg-green-100 text-green-800 rounded">
                Thanks for subscribing!
            </div>

            <div x-show="!success" class="flex gap-2">
                <x-inkwell::subscribe.input
                    class="flex-1 px-4 py-2 border rounded"
                    x-bind:class="error && 'border-red-500'"
                />
                <x-inkwell::subscribe.submit class="px-4 py-2 bg-blue-600 text-white rounded">
                    Subscribe
                </x-inkwell::subscribe.submit>
            </div>

            <p x-show="error" x-text="error" class="text-sm text-red-600"></p>
        </x-inkwell::subscribe.form>

    </div>

    <div class="posts">
        @forelse($posts as $post)
            <article style="margin-bottom: 2.5rem; padding-bottom: 2.5rem; border-bottom: 1px solid #e5e5e5;">
                <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem;">
                    <a href="{{ route('inkwell.post', $post->slug) }}" style="color: #1a1a1a;">
                        {{ $post->title }}
                    </a>
                </h2>
                <time style="font-size: 0.875rem; color: #666;" datetime="{{ $post->published_at->toISOString() }}">
                    {{ $post->published_at->format('F j, Y') }}
                </time>
                @if($post->excerpt)
                    <p style="margin-top: 0.75rem; color: #444;">{{ $post->excerpt }}</p>
                @endif
            </article>
        @empty
            <p style="color: #666;">No posts yet.</p>
        @endforelse
    </div>

    {{ $posts->links() }}
@endsection
