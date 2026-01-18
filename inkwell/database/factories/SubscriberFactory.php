<?php

namespace NiftyCo\Inkwell\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NiftyCo\Inkwell\Models\Subscriber;

class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
            'metadata' => null,
            'notes' => null,
            'confirmed_at' => fake()->boolean(80) ? now() : null,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn () => [
            'confirmed_at' => now(),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'confirmed_at' => null,
        ]);
    }

    public function withMetadata(array $metadata): static
    {
        return $this->state(fn () => [
            'metadata' => $metadata,
        ]);
    }

    public function withNotes(string $notes): static
    {
        return $this->state(fn () => [
            'notes' => $notes,
        ]);
    }
}
