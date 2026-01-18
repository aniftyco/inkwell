<?php

namespace NiftyCo\Inkwell\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void routes(array $attributes = [])
 * @method static \NiftyCo\Inkwell\Support\ThemeManager themes()
 * @method static \NiftyCo\Inkwell\Theme\Theme|null activeTheme()
 *
 * @see \NiftyCo\Inkwell\InkwellManager
 */
class Inkwell extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NiftyCo\Inkwell\InkwellManager::class;
    }
}
