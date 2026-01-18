<div>
    <x-slot:actions>
        <a href="{{ route('inkwell.posts.edit', $post) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            Edit Post
        </a>
    </x-slot:actions>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="prose max-w-none">
                    {!! $content !!}
                </div>
            </div>

            <!-- Replies -->
            @if($post->replies->count() > 0)
                <div class="mt-8 bg-white rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Replies ({{ $post->replies->count() }})</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($post->replies as $reply)
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-gray-900">
                                        {{ $reply->repliable?->subscriber?->email ?? 'Unknown' }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                @if($reply->repliable)
                                    <p class="text-gray-600">{{ $reply->repliable->body }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Post Info -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-medium text-gray-900 mb-4">Post Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm text-gray-500">Author</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $post->user?->name ?? 'Unknown' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Visibility</dt>
                        <dd>
                            @php
                                $colors = [
                                    'public' => 'bg-green-100 text-green-800',
                                    'subscribers' => 'bg-blue-100 text-blue-800',
                                    'draft' => 'bg-gray-100 text-gray-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$post->visibility->value] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($post->visibility->value) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Created</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $post->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    @if($post->published_at)
                        <div>
                            <dt class="text-sm text-gray-500">Published</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $post->published_at->format('M j, Y g:i A') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Campaigns -->
            @if($post->campaigns->count() > 0)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="font-medium text-gray-900 mb-4">Campaigns</h3>
                    <div class="space-y-3">
                        @foreach($post->campaigns as $campaign)
                            <a href="{{ route('inkwell.campaigns.show', $campaign) }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="font-medium text-sm text-gray-900">{{ $campaign->subject }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ ucfirst($campaign->status->value) }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
