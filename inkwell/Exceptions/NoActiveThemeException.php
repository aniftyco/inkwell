<?php

namespace NiftyCo\Inkwell\Exceptions;

use Exception;

class NoActiveThemeException extends Exception
{
    public function __construct()
    {
        parent::__construct('No active theme found. Please ensure a valid theme is installed and activated.');
    }
}
