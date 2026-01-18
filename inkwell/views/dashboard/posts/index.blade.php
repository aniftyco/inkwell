<div>
    <x-slot:actions>
        <a href="{{ route('inkwell.posts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            New Post
        </a>
    </x-slot:actions>

    @if(session('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="mb-6 flex items-center space-x-4">
        <div class="flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search posts..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <select wire:model.live="visibility" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All visibility</option>
            @foreach($visibilities as $vis)
                <option value="{{ $vis->value }}">{{ ucfirst($vis->value) }}</option>
            @endforeach
        </select>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visibility</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($posts as $post)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('inkwell.posts.show', $post) }}" class="text-gray-900 font-medium hover:text-blue-600">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $post->user?->name ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
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
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($post->published_at)
                                {{ $post->published_at->format('M j, Y') }}
                            @else
                                <span class="text-gray-400">Not published</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('inkwell.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-900 mr-4">Edit</a>
                            <button wire:click="delete({{ $post->id }})" wire:confirm="Are you sure you want to delete this post?" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No posts found.
                            <a href="{{ route('inkwell.posts.create') }}" class="text-blue-600 hover:underline">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>
