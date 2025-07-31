<?php

namespace App\Http\Pages;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Livewire\Component;

class ConfirmSubscription extends Component
{
    public function render(Request $request)
    {
        $subscriber = Subscriber::findOrFail($request->subscriber);

        if ($subscriber->confirmed_at === null) {
            $subscriber->update(['confirmed_at' => now()]);
        }

        return <<<'BLADE'
            <main class="flex-1">
                <h1>Thank you for confirming your subscription!</h1>
            </main>
            BLADE;
    }
}
