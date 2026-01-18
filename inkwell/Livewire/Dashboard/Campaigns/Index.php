<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Campaigns;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use NiftyCo\Inkwell\Models\Campaign;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Campaigns')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $campaigns = Campaign::with(['post', 'emails'])
            ->when($this->search, fn ($q) => $q->where('subject', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->latest()
            ->paginate(15);

        return view('inkwell::dashboard.campaigns.index', [
            'campaigns' => $campaigns,
        ]);
    }
}
