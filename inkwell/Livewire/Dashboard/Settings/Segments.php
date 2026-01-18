<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Settings;

use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use NiftyCo\Inkwell\Models\Segment;
use NiftyCo\Inkwell\Models\Tag;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Segments')]
class Segments extends Component
{
    public ?Segment $editingSegment = null;
    public string $name = '';
    public string $slug = '';
    public array $selectedTags = [];
    public bool $showCreate = false;

    public function edit(Segment $segment)
    {
        $this->editingSegment = $segment;
        $this->name = $segment->name;
        $this->slug = $segment->slug;
        $this->selectedTags = $segment->tag_ids ?? [];
        $this->showCreate = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:segments,slug,' . ($this->editingSegment?->id ?? 'NULL'),
            'selectedTags' => 'required|array|min:1',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'tag_ids' => array_map('intval', $this->selectedTags),
        ];

        if ($this->editingSegment) {
            $this->editingSegment->update($data);
            session()->flash('message', 'Segment updated successfully.');
        } else {
            Segment::create($data);
            session()->flash('message', 'Segment created successfully.');
        }

        $this->reset(['name', 'slug', 'selectedTags', 'editingSegment', 'showCreate']);
    }

    public function updatedName()
    {
        if (! $this->editingSegment) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function delete(Segment $segment)
    {
        $segment->delete();
        session()->flash('message', 'Segment deleted.');
    }

    public function cancel()
    {
        $this->reset(['name', 'slug', 'selectedTags', 'editingSegment', 'showCreate']);
    }

    public function render()
    {
        return view('inkwell::dashboard.settings.segments', [
            'segments' => Segment::all(),
            'tags' => Tag::all(),
        ]);
    }
}
