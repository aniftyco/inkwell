<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="text-sm font-medium text-gray-500">Total Posts</div>
            <div class="mt-2 flex items-baseline">
                <span class="text-3xl font-semibold text-gray-900">{{ $stats['posts'] }}</span>
                <span class="ml-2 text-sm text-gray-500">{{ $stats['published_posts'] }} published</span>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="text-sm font-medium text-gray-500">Subscribers</div>
            <div class="mt-2 flex items-baseline">
                <span class="text-3xl font-semibold text-gray-900">{{ $stats['subscribers'] }}</span>
                <span class="ml-2 text-sm text-gray-500">{{ $stats['active_subscribers'] }} confirmed</span>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="text-sm font-medium text-gray-500">Campaigns</div>
            <div class="mt-2 flex items-baseline">
                <span class="text-3xl font-semibold text-gray-900">{{ $stats['campaigns'] }}</span>
                <span class="ml-2 text-sm text-gray-500">{{ $stats['sent_campaigns'] }} sent</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Posts -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Recent Posts</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentPosts as $post)
                    <a href="{{ route('inkwell.posts.show', $post) }}" class="block px-6 py-4 hover:bg-gray-50">
                        <div class="font-medium text-gray-900">{{ $post->title }}</div>
                        <div class="mt-1 text-sm text-gray-500">
                            {{ $post->created_at->diffForHumans() }}
                            @if($post->user)
                                by {{ $post->user->name }}
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No posts yet.
                        <a href="{{ route('inkwell.posts.create') }}" class="text-blue-600 hover:underline">Create one</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Subscribers -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Recent Subscribers</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentSubscribers as $subscriber)
                    <a href="{{ route('inkwell.subscribers.show', $subscriber) }}" class="block px-6 py-4 hover:bg-gray-50">
                        <div class="font-medium text-gray-900">{{ $subscriber->email }}</div>
                        <div class="mt-1 text-sm text-gray-500">
                            {{ $subscriber->created_at->diffForHumans() }}
                            @if($subscriber->confirmed_at)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Confirmed</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No subscribers yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
