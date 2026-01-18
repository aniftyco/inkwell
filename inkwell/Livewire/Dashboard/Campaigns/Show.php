<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Campaigns;

use Livewire\Attributes\Layout;
use Livewire\Component;
use NiftyCo\Inkwell\Models\Campaign;

#[Layout('inkwell::layouts.dashboard')]
class Show extends Component
{
    public Campaign $campaign;

    public function mount(Campaign $campaign)
    {
        $this->campaign = $campaign->load(['post', 'tags', 'emails.subscriber']);
    }

    public function render()
    {
        $stats = $this->getStats();

        return view('inkwell::dashboard.campaigns.show', [
            'stats' => $stats,
        ])->title($this->campaign->subject);
    }

    protected function getStats(): array
    {
        $emails = $this->campaign->emails;

        return [
            'total' => $emails->count(),
            'queued' => $emails->where('status.value', 'queued')->count(),
            'sent' => $emails->where('status.value', 'sent')->count(),
            'delivered' => $emails->where('status.value', 'delivered')->count(),
            'bounced' => $emails->where('status.value', 'bounced')->count(),
            'complained' => $emails->where('status.value', 'complained')->count(),
            'failed' => $emails->where('status.value', 'failed')->count(),
        ];
    }
}
