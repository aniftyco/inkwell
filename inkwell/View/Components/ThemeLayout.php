<?php

namespace NiftyCo\Inkwell\View\Components;

use Illuminate\View\Component;
use NiftyCo\Inkwell\Support\ThemeManager;

class ThemeLayout extends Component
{
    public function __construct(
        public ?string $title,
        protected ThemeManager $themeManager,
    ) {}

    public function render()
    {
        $theme = $this->themeManager->active();

        if ($theme && $this->themeManager->hasView('layouts.theme')) {
            return view('inkwell-theme::layouts.theme');
        }

        return view('inkwell::layouts.theme');
    }
}
