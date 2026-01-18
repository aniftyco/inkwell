<div>
    <!-- Filters -->
    <div class="mb-6 flex items-center space-x-4">
        <div class="flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search campaigns..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <select wire:model.live="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All statuses</option>
            <option value="draft">Draft</option>
            <option value="scheduled">Scheduled</option>
            <option value="sending">Sending</option>
            <option value="sent">Sent</option>
        </select>
    </div>

    <!-- Campaigns Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Post</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($campaigns as $campaign)
                    @php
                        $total = $campaign->emails->count();
                        $delivered = $campaign->emails->where('status.value', 'delivered')->count();
                        $bounced = $campaign->emails->where('status.value', 'bounced')->count();
                    @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('inkwell.campaigns.show', $campaign) }}" class="text-gray-900 font-medium hover:text-blue-600">
                                {{ $campaign->subject }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($campaign->post)
                                <a href="{{ route('inkwell.posts.show', $campaign->post) }}" class="text-blue-600 hover:underline">
                                    {{ Str::limit($campaign->post->title, 30) }}
                                </a>
                            @else
                                <span class="text-gray-400">Standalone</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $colors = [
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'scheduled' => 'bg-yellow-100 text-yellow-800',
                                    'sending' => 'bg-blue-100 text-blue-800',
                                    'sent' => 'bg-green-100 text-green-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$campaign->status->value] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($campaign->status->value) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $campaign->sent_at?->format('M j, Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($total > 0)
                                <div class="flex items-center space-x-3">
                                    <span class="text-gray-600">{{ $total }} sent</span>
                                    @if($delivered > 0)
                                        <span class="text-green-600">{{ $delivered }} delivered</span>
                                    @endif
                                    @if($bounced > 0)
                                        <span class="text-red-600">{{ $bounced }} bounced</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('inkwell.campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No campaigns found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $campaigns->links() }}
    </div>
</div>
