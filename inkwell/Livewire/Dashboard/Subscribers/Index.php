<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Subscribers;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use NiftyCo\Inkwell\Models\Subscriber;
use NiftyCo\Inkwell\Models\Tag;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Subscribers')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public array $selectedTags = [];
    public array $selected = [];
    public bool $selectAll = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getQuery()->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function delete(Subscriber $subscriber)
    {
        $subscriber->delete();
        session()->flash('message', 'Subscriber deleted successfully.');
    }

    public function bulkDelete()
    {
        Subscriber::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('message', count($this->selected) . ' subscribers deleted.');
    }

    protected function getQuery()
    {
        return Subscriber::query()
            ->when($this->search, fn ($q) => $q->where('email', 'like', "%{$this->search}%")
                ->orWhere('name', 'like', "%{$this->search}%"))
            ->when($this->status === 'confirmed', fn ($q) => $q->whereNotNull('confirmed_at'))
            ->when($this->status === 'pending', fn ($q) => $q->whereNull('confirmed_at'))
            ->when($this->status === 'unsubscribed', fn ($q) => $q->onlyTrashed())
            ->when(! empty($this->selectedTags), fn ($q) => $q->whereHas('tags', fn ($t) => $t->whereIn('tags.id', $this->selectedTags)))
            ->withTrashed()
            ->latest();
    }

    public function render()
    {
        return view('inkwell::dashboard.subscribers.index', [
            'subscribers' => $this->getQuery()->paginate(25),
            'tags' => Tag::all(),
        ]);
    }
}
