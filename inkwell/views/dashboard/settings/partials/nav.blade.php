<div class="mb-6">
    <nav class="flex space-x-4">
        <a href="{{ route('inkwell.settings.general') }}"
           class="px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('inkwell.settings.general') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
            General
        </a>
        <a href="{{ route('inkwell.settings.themes') }}"
           class="px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('inkwell.settings.themes') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
            Themes
        </a>
        <a href="{{ route('inkwell.settings.users') }}"
           class="px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('inkwell.settings.users') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
            Users
        </a>
        <a href="{{ route('inkwell.settings.roles') }}"
           class="px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('inkwell.settings.roles') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
            Roles
        </a>
        <a href="{{ route('inkwell.settings.tags') }}"
           class="px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('inkwell.settings.tags') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
            Tags
        </a>
        <a href="{{ route('inkwell.settings.segments') }}"
           class="px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('inkwell.settings.segments') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
            Segments
        </a>
    </nav>
</div>
