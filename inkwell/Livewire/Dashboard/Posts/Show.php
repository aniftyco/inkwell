<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Posts;

use Livewire\Attributes\Layout;
use Livewire\Component;
use NiftyCo\Inkwell\Models\Post;
use NiftyCo\Inkwell\Support\MarkdownRenderer;

#[Layout('inkwell::layouts.dashboard')]
class Show extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post->load(['user', 'campaigns', 'replies.repliable.subscriber']);
    }

    public function render()
    {
        $renderer = app(MarkdownRenderer::class);

        return view('inkwell::dashboard.posts.show', [
            'content' => $renderer->render($this->post->content),
        ])->title($this->post->title);
    }
}
