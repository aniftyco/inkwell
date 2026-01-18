<div>
    @if(session('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="mb-6 flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[200px]">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by email or name..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <select wire:model.live="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All statuses</option>
            <option value="confirmed">Confirmed</option>
            <option value="pending">Pending</option>
            <option value="unsubscribed">Unsubscribed</option>
        </select>
        @if(count($selected) > 0)
            <button wire:click="bulkDelete" wire:confirm="Are you sure you want to delete {{ count($selected) }} subscribers?"
                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">
                Delete Selected ({{ count($selected) }})
            </button>
        @endif
    </div>

    <!-- Subscribers Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tags</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($subscribers as $subscriber)
                    <tr class="{{ $subscriber->trashed() ? 'bg-gray-50' : '' }}">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:model.live="selected" value="{{ $subscriber->id }}" class="rounded border-gray-300">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('inkwell.subscribers.show', $subscriber) }}" class="text-gray-900 font-medium hover:text-blue-600">
                                {{ $subscriber->email }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $subscriber->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($subscriber->trashed())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Unsubscribed</span>
                            @elseif($subscriber->confirmed_at)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Confirmed</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @foreach($subscriber->tags->take(3) as $tag)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ $tag->slug }}
                                    </span>
                                @endforeach
                                @if($subscriber->tags->count() > 3)
                                    <span class="text-xs text-gray-500">+{{ $subscriber->tags->count() - 3 }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $subscriber->created_at->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('inkwell.subscribers.show', $subscriber) }}" class="text-blue-600 hover:text-blue-900 mr-4">View</a>
                            <button wire:click="delete({{ $subscriber->id }})" wire:confirm="Are you sure?" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            No subscribers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $subscribers->links() }}
    </div>
</div>
