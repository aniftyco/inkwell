<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
        <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
            <div class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</div>
            <div class="text-sm text-gray-500">Total</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
            <div class="text-2xl font-semibold text-gray-600">{{ $stats['queued'] }}</div>
            <div class="text-sm text-gray-500">Queued</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
            <div class="text-2xl font-semibold text-blue-600">{{ $stats['sent'] }}</div>
            <div class="text-sm text-gray-500">Sent</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
            <div class="text-2xl font-semibold text-green-600">{{ $stats['delivered'] }}</div>
            <div class="text-sm text-gray-500">Delivered</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
            <div class="text-2xl font-semibold text-red-600">{{ $stats['bounced'] }}</div>
            <div class="text-sm text-gray-500">Bounced</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
            <div class="text-2xl font-semibold text-orange-600">{{ $stats['complained'] }}</div>
            <div class="text-sm text-gray-500">Complained</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
            <div class="text-2xl font-semibold text-gray-600">{{ $stats['failed'] }}</div>
            <div class="text-sm text-gray-500">Failed</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Recipient List -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Recipients</h2>
                </div>
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @forelse($campaign->emails as $email)
                        <div class="px-6 py-3 flex items-center justify-between">
                            <div>
                                <a href="{{ route('inkwell.subscribers.show', $email->subscriber) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                    {{ $email->subscriber->email }}
                                </a>
                                <div class="text-xs text-gray-500">{{ $email->sent_at?->format('M j, Y g:i A') ?? 'Not sent' }}</div>
                            </div>
                            @php
                                $statusColors = [
                                    'queued' => 'bg-gray-100 text-gray-800',
                                    'sending' => 'bg-blue-100 text-blue-800',
                                    'sent' => 'bg-blue-100 text-blue-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'bounced' => 'bg-red-100 text-red-800',
                                    'complained' => 'bg-orange-100 text-orange-800',
                                    'failed' => 'bg-gray-100 text-gray-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusColors[$email->status->value] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($email->status->value) }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">No emails in this campaign.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Campaign Info -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-medium text-gray-900 mb-4">Campaign Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm text-gray-500">Subject</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $campaign->subject }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Status</dt>
                        <dd>
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
                        </dd>
                    </div>
                    @if($campaign->post)
                        <div>
                            <dt class="text-sm text-gray-500">Related Post</dt>
                            <dd>
                                <a href="{{ route('inkwell.posts.show', $campaign->post) }}" class="text-sm text-blue-600 hover:underline">
                                    {{ $campaign->post->title }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if($campaign->scheduled_at)
                        <div>
                            <dt class="text-sm text-gray-500">Scheduled</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $campaign->scheduled_at->format('M j, Y g:i A') }}</dd>
                        </div>
                    @endif
                    @if($campaign->sent_at)
                        <div>
                            <dt class="text-sm text-gray-500">Sent</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $campaign->sent_at->format('M j, Y g:i A') }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-sm text-gray-500">Created</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $campaign->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Tags -->
            @if($campaign->tags->count() > 0)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="font-medium text-gray-900 mb-4">Target Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($campaign->tags as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                {{ $tag->slug }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
