<div>
    @include('inkwell::dashboard.settings.partials.nav')

    @if(session('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="space-y-6">
            <div>
                <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                <input wire:model="site_name" type="text" id="site_name"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('site_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="site_description" class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
                <textarea wire:model="site_description" id="site_description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="A short description of your blog..."></textarea>
                @error('site_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="posts_per_page" class="block text-sm font-medium text-gray-700 mb-1">Posts Per Page</label>
                <input wire:model="posts_per_page" type="number" id="posts_per_page" min="1" max="100"
                       class="w-32 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('posts_per_page') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="border-t border-gray-200 pt-6 space-y-4">
                <h3 class="font-medium text-gray-900">Subscriber Settings</h3>

                <label class="flex items-center">
                    <input wire:model="require_confirmation" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Require email confirmation for new subscribers</span>
                </label>

                <label class="flex items-center">
                    <input wire:model="allow_comments" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Allow subscribers to reply to posts via email</span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                    Save Settings
                </button>
            </div>
        </div>
    </form>
</div>
