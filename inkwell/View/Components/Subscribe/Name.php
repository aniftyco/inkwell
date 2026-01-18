<?php

namespace NiftyCo\Inkwell\View\Components\Subscribe;

use Illuminate\View\Component;

class Name extends Component
{
    public function __construct(
        public string $placeholder = 'Your name (optional)',
    ) {}

    public function render()
    {
        return view('inkwell::components.subscribe.name');
    }
}
