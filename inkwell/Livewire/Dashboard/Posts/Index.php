<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Posts;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use NiftyCo\Inkwell\Enums\PostVisibility;
use NiftyCo\Inkwell\Models\Post;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Posts')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $visibility = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Post $post)
    {
        $post->delete();
        session()->flash('message', 'Post deleted successfully.');
    }

    public function render()
    {
        $posts = Post::with('user')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->visibility, fn ($q) => $q->where('visibility', $this->visibility))
            ->latest()
            ->paginate(15);

        return view('inkwell::dashboard.posts.index', [
            'posts' => $posts,
            'visibilities' => PostVisibility::cases(),
        ]);
    }
}
