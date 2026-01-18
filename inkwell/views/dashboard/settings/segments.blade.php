<div>
    @include('inkwell::dashboard.settings.partials.nav')

    @if(session('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 flex justify-end">
        <button wire:click="$toggle('showCreate')" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            Add Segment
        </button>
    </div>

    @if($showCreate)
        <div class="mb-6 bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-medium text-gray-900 mb-4">{{ $editingSegment ? 'Edit Segment' : 'Create Segment' }}</h3>
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input wire:model.live="name" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input wire:model="slug" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg font-mono text-sm">
                        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags (subscribers must have ALL selected tags)</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <label class="inline-flex items-center px-3 py-1 rounded-full border cursor-pointer
                                {{ in_array($tag->id, $selectedTags) ? 'bg-blue-100 border-blue-300 text-blue-800' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-gray-100' }}">
                                <input wire:model="selectedTags" type="checkbox" value="{{ $tag->id }}" class="hidden">
                                <span>{{ $tag->slug }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('selectedTags') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                        {{ $editingSegment ? 'Update Segment' : 'Create Segment' }}
                    </button>
                    <button type="button" wire:click="cancel" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tags</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($segments as $segment)
                    @php
                        $segmentTags = $tags->whereIn('id', $segment->tag_ids ?? []);
                    @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $segment->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $segment->slug }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($segmentTags as $tag)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ $tag->slug }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $segment->id }})" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                            <button wire:click="delete({{ $segment->id }})" wire:confirm="Are you sure?" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            No segments found. Segments let you save tag combinations for easy subscriber filtering.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
