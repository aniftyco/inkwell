<?php

namespace NiftyCo\Inkwell\View\Components\Subscribe;

use Illuminate\View\Component;

class Form extends Component
{
    public function __construct(
        public array $tags = [],
    ) {}

    public function render()
    {
        return view('inkwell::components.subscribe.form');
    }
}
