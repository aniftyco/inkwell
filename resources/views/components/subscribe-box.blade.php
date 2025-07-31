  <div class="border-t rounded border-accent/60 px-4 pt-6 pb-4 bg-gray-50">
      @if ($message = session('subscribed'))
          <p class="w-full text-center font-medium">{{ $message }}</p>
      @else
          <div class="flex flex-col items-center justify-center pb-4">
              <p class="text-center font-semibold">Become a Subscriber</p>
              <p class="text-center">Get exclusive content and updates delivered to your inbox.</p>
          </div>
          <form class="flex flex-col items-center gap-2 px-0 sm:px-24 lg:flex-row" method="post" wire:submit="subscribe">
              <input
                  class="focus:border-accent w-full flex-1 border bg-white rounded p-2 focus:outline-none focus:ring-0"
                  placeholder="Enter your email" wire:model="email" />
              <button
                  class="bg-accent rounded cursor-pointer text-white/90 hover:bg-accent/80 focus:bg-accent/80 w-full border border-transparent px-4 py-2 focus:outline-none focus:ring-0 lg:w-auto"
                  type="submit">
                  Subscribe
              </button>
          </form>
          @error('email')
              <p class="mt-1 sm:px-24 text-xs text-red-600 text-center sm:text-left">{{ $message }}</p>
          @enderror
          <p class="pt-4 text-center text-sm">
              We respect your inbox and will never send spam or share your email address.
          </p>
      @endif
  </div>
