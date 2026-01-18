<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Settings;

use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use NiftyCo\Inkwell\Models\Tag;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Tags')]
class Tags extends Component
{
    public string $newTag = '';

    public function create()
    {
        $this->validate([
            'newTag' => 'required|string|max:50',
        ]);

        $slug = Str::slug($this->newTag);

        if (Tag::where('slug', $slug)->exists()) {
            $this->addError('newTag', 'This tag already exists.');

            return;
        }

        Tag::create(['slug' => $slug]);
        $this->newTag = '';
        session()->flash('message', 'Tag created successfully.');
    }

    public function delete(Tag $tag)
    {
        $tag->delete();
        session()->flash('message', 'Tag deleted.');
    }

    public function render()
    {
        return view('inkwell::dashboard.settings.tags', [
            'tags' => Tag::withCount('subscribers')->orderBy('slug')->get(),
        ]);
    }
}
