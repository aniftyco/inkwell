<?php

namespace NiftyCo\Inkwell\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NiftyCo\Inkwell\Enums\CampaignStatus;
use NiftyCo\Inkwell\Models\Campaign;
use NiftyCo\Inkwell\Models\Post;

class CampaignFactory extends Factory
{
    protected $model = Campaign::class;

    public function definition(): array
    {
        return [
            'post_id' => null,
            'subject' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'template' => 'default',
            'status' => CampaignStatus::Draft,
            'scheduled_at' => null,
            'sent_at' => null,
        ];
    }

    public function forPost(Post $post): static
    {
        return $this->state(fn () => [
            'post_id' => $post->id,
            'subject' => $post->title,
            'body' => $post->content,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => CampaignStatus::Draft,
            'scheduled_at' => null,
            'sent_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn () => [
            'status' => CampaignStatus::Scheduled,
            'scheduled_at' => fake()->dateTimeBetween('now', '+1 week'),
            'sent_at' => null,
        ]);
    }

    public function sending(): static
    {
        return $this->state(fn () => [
            'status' => CampaignStatus::Sending,
            'scheduled_at' => now(),
            'sent_at' => null,
        ]);
    }

    public function sent(): static
    {
        return $this->state(fn () => [
            'status' => CampaignStatus::Sent,
            'scheduled_at' => fake()->dateTimeBetween('-1 week', '-1 hour'),
            'sent_at' => now(),
        ]);
    }
}
