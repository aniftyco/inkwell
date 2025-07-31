<?php

namespace App\Http\Components;

use App\Mail\ConfirmSubscription;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SubscribeBox extends Component
{
    public bool $gateway = false;

    #[Validate('required|email')]
    public ?string $email = '';

    public function subscribe(): void
    {
        $this->validate(messages: [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $subscriber = Subscriber::firstOrCreate(['email' => $this->email]);

        if (! $subscriber->confirmed_at) {
            $url = url()->signedRoute('subscription.confirm', ['subscriber' => $subscriber->id]);

            Mail::to($subscriber->email)->send(new ConfirmSubscription($url));
        }

        session()->flash('subscribed', 'You should be getting an email shortly to confirm your subscription.');
    }

    public function render()
    {
        return view('components.subscribe-box');
    }
}
