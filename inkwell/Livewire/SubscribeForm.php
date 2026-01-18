<?php

namespace NiftyCo\Inkwell\Livewire;

use Livewire\Component;
use NiftyCo\Inkwell\Models\Subscriber;
use NiftyCo\Inkwell\Models\Tag;
use NiftyCo\Inkwell\Support\Settings;

class SubscribeForm extends Component
{
    public string $email = '';

    public string $name = '';

    public array $tags = [];

    public string $formClass = '';

    public bool $success = false;

    public function mount(array $tags = [], string $formClass = '')
    {
        $this->tags = $tags;
        $this->formClass = $formClass;
    }

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
        ]);

        $subscriber = Subscriber::withTrashed()->where('email', $this->email)->first();

        if ($subscriber) {
            if ($subscriber->trashed()) {
                $subscriber->restore();
                $subscriber->update([
                    'name' => $this->name ?: $subscriber->name,
                    'confirmed_at' => null,
                ]);
            }
        } else {
            $subscriber = Subscriber::create([
                'email' => $this->email,
                'name' => $this->name ?: null,
            ]);
        }

        if (! empty($this->tags)) {
            $tagModels = collect($this->tags)->map(fn ($slug) => Tag::firstOrCreate(['slug' => $slug]));
            $subscriber->tags()->syncWithoutDetaching($tagModels->pluck('id'));
        }

        if (Settings::get('require_confirmation', true) && ! $subscriber->confirmed_at) {
            $this->sendConfirmationEmail($subscriber);
        } else {
            $subscriber->update(['confirmed_at' => now()]);
        }

        $this->success = true;
        $this->reset(['email', 'name']);
    }

    protected function sendConfirmationEmail(Subscriber $subscriber): void
    {
        // TODO: Implement with Mailable
    }

    public function render()
    {
        return view('inkwell::livewire.subscribe-form');
    }
}
