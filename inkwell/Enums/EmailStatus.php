<?php

namespace NiftyCo\Inkwell\Enums;

enum EmailStatus: string
{
    case Queued = 'queued';
    case Sending = 'sending';
    case Sent = 'sent';
    case Delivered = 'delivered';
    case Bounced = 'bounced';
    case Complained = 'complained';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Queued => 'Queued',
            self::Sending => 'Sending',
            self::Sent => 'Sent',
            self::Delivered => 'Delivered',
            self::Bounced => 'Bounced',
            self::Complained => 'Complained',
            self::Failed => 'Failed',
        };
    }

    public function isSuccessful(): bool
    {
        return match ($this) {
            self::Sent, self::Delivered => true,
            default => false,
        };
    }

    public function isFailed(): bool
    {
        return match ($this) {
            self::Bounced, self::Complained, self::Failed => true,
            default => false,
        };
    }

    public function isPending(): bool
    {
        return match ($this) {
            self::Queued, self::Sending => true,
            default => false,
        };
    }

    public function shouldUnsubscribe(): bool
    {
        return match ($this) {
            self::Bounced, self::Complained => true,
            default => false,
        };
    }
}
