<div
    x-data="{
        email: @entangle('email'),
        name: @entangle('name'),
        success: @entangle('success'),
        get error() {
            return $wire.$errors.first('email')
        }
    }"
>
    <form wire:submit="subscribe" @class([$formClass])>
        {{ $slot }}
    </form>
</div>
