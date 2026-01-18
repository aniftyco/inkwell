<?php

namespace NiftyCo\Inkwell\Http\Controllers;

use NiftyCo\Inkwell\Models\Post;
use NiftyCo\Inkwell\Support\MarkdownRenderer;
use NiftyCo\Inkwell\Support\ThemeManager;

class PostController
{
    public function __invoke(string $slug, ThemeManager $themeManager, MarkdownRenderer $markdown)
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->public()
            ->first();

        if (! $post) {
            if ($themeManager->hasView('pages.404')) {
                return response()->view('inkwell-theme::pages.404', [], 404);
            }

            abort(404);
        }

        $content = $markdown->render($post->content);

        return view('inkwell-theme::pages.post', compact('post', 'content'));
    }
}
