<div>
    @include('inkwell::dashboard.settings.partials.nav')

    @if(session('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($themes as $slug => $theme)
            <div class="bg-white rounded-lg border {{ $activeTheme === $slug ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-200' }} overflow-hidden">
                <div class="aspect-video bg-gray-100 flex items-center justify-center">
                    <span class="text-gray-400 text-4xl">{{ strtoupper(substr($theme['name'], 0, 1)) }}</span>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium text-gray-900">{{ $theme['name'] }}</h3>
                        @if($activeTheme === $slug)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Active</span>
                        @endif
                    </div>
                    @if(isset($theme['description']))
                        <p class="text-sm text-gray-500 mb-3">{{ $theme['description'] }}</p>
                    @endif
                    <div class="text-xs text-gray-400 mb-4">
                        @if(isset($theme['author']))
                            By {{ $theme['author'] }}
                        @endif
                        @if(isset($theme['version']))
                            &middot; v{{ $theme['version'] }}
                        @endif
                    </div>
                    @if($activeTheme !== $slug)
                        <button wire:click="activate('{{ $slug }}')"
                                class="w-full px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                            Activate
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg border border-gray-200 p-12 text-center">
                <p class="text-gray-500">No themes found.</p>
                <p class="text-sm text-gray-400 mt-2">Add themes to the <code class="bg-gray-100 px-1 rounded">themes/</code> directory.</p>
            </div>
        @endforelse
    </div>
</div>
