<button type="submit" wire:loading.attr="disabled" {{ $attributes }}>
    <span wire:loading.remove>{{ $slot }}</span>
    <span wire:loading>...</span>
</button>
