<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Subscribers;

use Livewire\Attributes\Layout;
use Livewire\Component;
use NiftyCo\Inkwell\Models\Subscriber;
use NiftyCo\Inkwell\Models\Tag;

#[Layout('inkwell::layouts.dashboard')]
class Show extends Component
{
    public Subscriber $subscriber;
    public string $notes = '';
    public array $metadata = [];
    public string $newMetaKey = '';
    public string $newMetaValue = '';

    public function mount(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber->load(['tags', 'emails.campaign']);
        $this->notes = $subscriber->notes ?? '';
        $this->metadata = $subscriber->metadata ?? [];
    }

    public function saveNotes()
    {
        $this->subscriber->update(['notes' => $this->notes]);
        session()->flash('message', 'Notes saved.');
    }

    public function addMetadata()
    {
        $this->validate([
            'newMetaKey' => 'required|string|max:50',
            'newMetaValue' => 'required|string|max:255',
        ]);

        $this->metadata[$this->newMetaKey] = $this->newMetaValue;
        $this->subscriber->update(['metadata' => $this->metadata]);
        $this->newMetaKey = '';
        $this->newMetaValue = '';
        session()->flash('message', 'Metadata added.');
    }

    public function removeMetadata(string $key)
    {
        unset($this->metadata[$key]);
        $this->subscriber->update(['metadata' => $this->metadata]);
        session()->flash('message', 'Metadata removed.');
    }

    public function toggleTag(Tag $tag)
    {
        if ($this->subscriber->tags->contains($tag)) {
            $this->subscriber->tags()->detach($tag);
        } else {
            $this->subscriber->tags()->attach($tag);
        }
        $this->subscriber->load('tags');
    }

    public function render()
    {
        return view('inkwell::dashboard.subscribers.show', [
            'allTags' => Tag::all(),
        ])->title($this->subscriber->email);
    }
}
