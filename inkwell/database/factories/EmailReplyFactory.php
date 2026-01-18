<?php

namespace NiftyCo\Inkwell\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NiftyCo\Inkwell\Models\EmailReply;
use NiftyCo\Inkwell\Models\Subscriber;

class EmailReplyFactory extends Factory
{
    protected $model = EmailReply::class;

    public function definition(): array
    {
        return [
            'subscriber_id' => Subscriber::factory(),
            'subject' => 'Re: ' . fake()->sentence(),
            'body' => fake()->paragraphs(2, true),
            'message_id' => EmailReply::generateMessageId(),
            'in_reply_to' => '<' . fake()->uuid() . '@example.com>',
            'references' => null,
            'headers' => null,
        ];
    }

    public function inReplyTo(string $messageId): static
    {
        return $this->state(fn () => [
            'in_reply_to' => $messageId,
        ]);
    }

    public function withHeaders(array $headers): static
    {
        return $this->state(fn () => [
            'headers' => $headers,
        ]);
    }
}
