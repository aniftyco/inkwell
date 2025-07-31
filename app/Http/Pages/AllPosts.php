<?php

namespace App\Http\Pages;

use App\Models\Post;
use Illuminate\Http\Request;
use Livewire\Component;

class AllPosts extends Component
{
    public function render(Request $request)
    {
        $posts = Post::with('author')->latest()->published()->get();

        return view('pages.index', compact('posts'));
    }
}
