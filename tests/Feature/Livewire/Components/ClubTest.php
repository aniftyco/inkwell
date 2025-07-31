<?php

use App\Http\Components\Club;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Club::class)
        ->assertStatus(200);
});
