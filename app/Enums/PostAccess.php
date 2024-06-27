<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PostAccess: string implements HasLabel
{
    case PUBLIC = 'PUBLIC';
    case MEMBERS_ONLY = 'MEMBERS_ONLY';

    public function getLabel(): string
    {
        return match ($this) {
            self::PUBLIC => 'Public',
            self::MEMBERS_ONLY => 'Members Only',
        };
    }
}
