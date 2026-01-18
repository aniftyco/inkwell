<?php

namespace NiftyCo\Inkwell\Enums;

enum CampaignStatus: string
{
    case Draft = 'draft';
    case Scheduled = 'scheduled';
    case Sending = 'sending';
    case Sent = 'sent';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Scheduled => 'Scheduled',
            self::Sending => 'Sending',
            self::Sent => 'Sent',
        };
    }

    public function canEdit(): bool
    {
        return match ($this) {
            self::Draft, self::Scheduled => true,
            self::Sending, self::Sent => false,
        };
    }

    public function canSend(): bool
    {
        return $this === self::Draft || $this === self::Scheduled;
    }

    public function canCancel(): bool
    {
        return $this === self::Scheduled;
    }
}
