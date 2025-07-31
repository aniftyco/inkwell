<?php

namespace Inkwell\Widgets;

use Filament\Widgets;

class InkwellInfo extends Widgets\Widget
{
    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    protected static string $view = 'inkwell::widgets.inkwell-info';
}
