<?php

namespace Inkwell\Widgets;

use Filament\Widgets;

class Welcome extends Widgets\Widget
{
    protected static ?int $sort = -3;

    protected static bool $isLazy = false;

    protected static string $view = 'inkwell::widgets.welcome';
}
