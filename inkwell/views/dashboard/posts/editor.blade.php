<div>
    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Editor -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input wire:model.live="title" type="text" id="title"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg font-medium"
                                   placeholder="Enter post title...">
                            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                            <input wire:model="slug" type="text" id="slug"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">
                            @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <div id="tiptap-editor" class="min-h-[400px] border border-gray-300 rounded-lg p-4" wire:ignore>
                        <!-- Tiptap editor will be mounted here -->
                    </div>
                    <textarea wire:model="content" id="content" rows="20"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                              placeholder="Write your content in Markdown..."></textarea>
                    @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    <p class="mt-2 text-xs text-gray-500">Supports Markdown. Use ![alt](attachment:ID) for images.</p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="font-medium text-gray-900 mb-4">Publish</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="visibility" class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
                            <select wire:model="visibility" id="visibility"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @foreach($visibilities as $vis)
                                    <option value="{{ $vis->value }}">{{ ucfirst($vis->value) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Publish Date</label>
                            <input wire:model="published_at" type="datetime-local" id="published_at"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Leave empty for draft, set future date to schedule.</p>
                        </div>

                        <div class="pt-4 border-t border-gray-200 space-y-2">
                            <button type="submit"
                                    class="w-full px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                                Save Draft
                            </button>
                            <button type="button" wire:click="publish"
                                    class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                                Publish Now
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="font-medium text-gray-900 mb-4">Excerpt</h3>
                    <textarea wire:model="excerpt" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                              placeholder="Optional short description..."></textarea>
                    @error('excerpt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </form>
</div>
