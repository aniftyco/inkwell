<div>
    @if(session('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Notes -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-medium text-gray-900 mb-4">Notes</h3>
                <textarea wire:model="notes" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Add notes about this subscriber..."></textarea>
                <button wire:click="saveNotes" class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                    Save Notes
                </button>
            </div>

            <!-- Custom Metadata -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-medium text-gray-900 mb-4">Custom Fields</h3>
                @if(count($metadata) > 0)
                    <div class="space-y-2 mb-4">
                        @foreach($metadata as $key => $value)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <span class="font-medium text-gray-700">{{ $key }}:</span>
                                    <span class="text-gray-600">{{ $value }}</span>
                                </div>
                                <button wire:click="removeMetadata('{{ $key }}')" class="text-red-600 hover:text-red-700 text-sm">Remove</button>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Key</label>
                        <input wire:model="newMetaKey" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                        <input wire:model="newMetaValue" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <button wire:click="addMetadata" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        Add
                    </button>
                </div>
            </div>

            <!-- Email History -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-medium text-gray-900">Email History</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($subscriber->emails as $email)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $email->campaign?->subject ?? 'Unknown Campaign' }}</div>
                                    <div class="text-sm text-gray-500">{{ $email->sent_at?->format('M j, Y g:i A') ?? 'Not sent' }}</div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $email->status->value === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $email->status->value === 'bounced' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $email->status->value === 'sent' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $email->status->value === 'queued' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($email->status->value) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">No emails sent yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Subscriber Info -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-medium text-gray-900 mb-4">Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm text-gray-500">Email</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $subscriber->email }}</dd>
                    </div>
                    @if($subscriber->name)
                        <div>
                            <dt class="text-sm text-gray-500">Name</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $subscriber->name }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-sm text-gray-500">Status</dt>
                        <dd>
                            @if($subscriber->trashed())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Unsubscribed</span>
                            @elseif($subscriber->confirmed_at)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Confirmed</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Subscribed</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $subscriber->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    @if($subscriber->confirmed_at)
                        <div>
                            <dt class="text-sm text-gray-500">Confirmed</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $subscriber->confirmed_at->format('M j, Y g:i A') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Tags -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-medium text-gray-900 mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($allTags as $tag)
                        <button wire:click="toggleTag({{ $tag->id }})"
                                class="px-3 py-1 text-sm rounded-full border {{ $subscriber->tags->contains($tag) ? 'bg-blue-100 border-blue-300 text-blue-800' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-gray-100' }}">
                            {{ $tag->slug }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
