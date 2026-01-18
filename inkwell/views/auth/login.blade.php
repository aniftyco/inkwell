<div class="w-full max-w-md">
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Inkwell</h1>
            <p class="text-gray-500 mt-1">Sign in to your account</p>
        </div>

        <form wire:submit="login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input wire:model="email" type="email" id="email" autofocus
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input wire:model="password" type="password" id="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input wire:model="remember" type="checkbox" id="remember"
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
            </div>

            <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>Sign in</span>
                <span wire:loading>Signing in...</span>
            </button>
        </form>
    </div>
</div>
