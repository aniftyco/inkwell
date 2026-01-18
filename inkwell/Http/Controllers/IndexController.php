<?php

namespace NiftyCo\Inkwell\Http\Controllers;

use NiftyCo\Inkwell\Models\Post;

class IndexController
{
    public function __invoke()
    {
        $posts = Post::published()
            ->public()
            ->latest('published_at')
            ->paginate(10);

        return view('inkwell-theme::pages.index', compact('posts'));
    }
}
