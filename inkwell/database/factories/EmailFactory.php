<?php

namespace NiftyCo\Inkwell\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NiftyCo\Inkwell\Enums\EmailStatus;
use NiftyCo\Inkwell\Models\Campaign;
use NiftyCo\Inkwell\Models\Email;
use NiftyCo\Inkwell\Models\Subscriber;

class EmailFactory extends Factory
{
    protected $model = Email::class;

    public function definition(): array
    {
        return [
            'campaign_id' => Campaign::factory(),
            'subscriber_id' => Subscriber::factory(),
            'message_id' => Email::generateMessageId(),
            'status' => EmailStatus::Queued,
            'sent_at' => null,
        ];
    }

    public function queued(): static
    {
        return $this->state(fn () => [
            'status' => EmailStatus::Queued,
            'sent_at' => null,
        ]);
    }

    public function sent(): static
    {
        return $this->state(fn () => [
            'status' => EmailStatus::Sent,
            'sent_at' => now(),
        ]);
    }

    public function delivered(): static
    {
        return $this->state(fn () => [
            'status' => EmailStatus::Delivered,
            'sent_at' => now(),
        ]);
    }

    public function bounced(): static
    {
        return $this->state(fn () => [
            'status' => EmailStatus::Bounced,
            'sent_at' => now(),
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn () => [
            'status' => EmailStatus::Failed,
            'sent_at' => null,
        ]);
    }
}
