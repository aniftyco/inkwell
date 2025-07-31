<?php

namespace App\Http\Pages;

use App\Models\Post;
use Illuminate\Http\Request;
use Livewire\Component;

class ShowPost extends Component
{
    public function render(Request $request)
    {
        $post = Post::with('author')->where('slug', $request->slug)->firstOrFail();

        return view('pages.show', compact('post'));
    }
}
