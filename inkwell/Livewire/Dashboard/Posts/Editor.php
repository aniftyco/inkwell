<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Posts;

use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use NiftyCo\Inkwell\Enums\PostVisibility;
use NiftyCo\Inkwell\Models\Post;

#[Layout('inkwell::layouts.dashboard')]
class Editor extends Component
{
    public ?Post $post = null;

    public string $title = '';
    public string $slug = '';
    public string $content = '';
    public string $excerpt = '';
    public string $visibility = 'draft';
    public ?string $published_at = null;
    public bool $autoSlug = true;

    public function mount(?Post $post = null)
    {
        if ($post && $post->exists) {
            $this->post = $post;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->content = $post->content;
            $this->excerpt = $post->excerpt ?? '';
            $this->visibility = $post->visibility->value;
            $this->published_at = $post->published_at?->format('Y-m-d\TH:i');
            $this->autoSlug = false;
        }
    }

    public function updatedTitle()
    {
        if ($this->autoSlug && ! $this->post) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . ($this->post?->id ?? 'NULL'),
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'visibility' => 'required|in:public,subscribers,draft',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt ?: null,
            'visibility' => PostVisibility::from($this->visibility),
            'published_at' => $this->published_at ? \Carbon\Carbon::parse($this->published_at) : null,
        ];

        if ($this->post) {
            $this->post->update($data);
            session()->flash('message', 'Post updated successfully.');
        } else {
            $data['user_id'] = auth()->id();
            $post = Post::create($data);
            $this->redirect(route('inkwell.posts.show', $post));

            return;
        }

        $this->redirect(route('inkwell.posts.show', $this->post));
    }

    public function publish()
    {
        $this->visibility = 'public';
        $this->published_at = now()->format('Y-m-d\TH:i');
        $this->save();
    }

    public function render()
    {
        return view('inkwell::dashboard.posts.editor', [
            'visibilities' => PostVisibility::cases(),
        ])->title($this->post ? 'Edit: ' . $this->post->title : 'New Post');
    }
}
