<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use NiftyCo\Inkwell\Models\Campaign;
use NiftyCo\Inkwell\Models\Post;
use NiftyCo\Inkwell\Models\Subscriber;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Dashboard')]
class Home extends Component
{
    public function render()
    {
        return view('inkwell::dashboard.home', [
            'stats' => $this->getStats(),
            'recentPosts' => $this->getRecentPosts(),
            'recentSubscribers' => $this->getRecentSubscribers(),
        ]);
    }

    protected function getStats(): array
    {
        return [
            'posts' => Post::count(),
            'published_posts' => Post::whereNotNull('published_at')->where('published_at', '<=', now())->count(),
            'subscribers' => Subscriber::count(),
            'active_subscribers' => Subscriber::whereNotNull('confirmed_at')->count(),
            'campaigns' => Campaign::count(),
            'sent_campaigns' => Campaign::where('status', 'sent')->count(),
        ];
    }

    protected function getRecentPosts()
    {
        return Post::with('user')
            ->latest()
            ->take(5)
            ->get();
    }

    protected function getRecentSubscribers()
    {
        return Subscriber::latest()
            ->take(5)
            ->get();
    }
}
