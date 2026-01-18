<?php

namespace NiftyCo\Inkwell\Enums;

enum PostVisibility: string
{
    case Public = 'public';
    case Subscribers = 'subscribers';
    case Draft = 'draft';

    public function label(): string
    {
        return match ($this) {
            self::Public => 'Public',
            self::Subscribers => 'Subscribers Only',
            self::Draft => 'Draft',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Public => 'Visible on website and emailed to subscribers',
            self::Subscribers => 'Emailed to subscribers only, not on website',
            self::Draft => 'Not published yet',
        };
    }

    public function isPublished(): bool
    {
        return $this !== self::Draft;
    }

    public function isEmailable(): bool
    {
        return $this !== self::Draft;
    }

    public function isPubliclyVisible(): bool
    {
        return $this === self::Public;
    }
}
