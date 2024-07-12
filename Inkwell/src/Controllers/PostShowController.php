<?php

namespace NiftyCo\Inkwell\Controllers;

use App\Models\Post;

class PostShowController
{
    public function __invoke($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('inkwell::pages.show', compact('post'));
    }
}
