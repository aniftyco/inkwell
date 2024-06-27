<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PostStatus: string implements HasLabel
{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case SCHEDULED = 'SCHEDULED';

    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::SCHEDULED => 'Scheduled',
        };
    }
}
