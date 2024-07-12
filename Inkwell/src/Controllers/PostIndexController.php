<?php

namespace NiftyCo\Inkwell\Controllers;

use App\Models\Post;

class PostIndexController
{
    public function __invoke()
    {
        $posts = Post::published()->simplePaginate(10);

        return view('inkwell::pages.index', compact('posts'));
    }
}
