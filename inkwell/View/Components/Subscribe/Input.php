<?php

namespace NiftyCo\Inkwell\View\Components\Subscribe;

use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $placeholder = 'your@email.com',
    ) {}

    public function render()
    {
        return view('inkwell::components.subscribe.input');
    }
}
