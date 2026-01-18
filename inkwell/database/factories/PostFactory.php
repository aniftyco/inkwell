<?php

namespace NiftyCo\Inkwell\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use NiftyCo\Inkwell\Enums\PostVisibility;
use NiftyCo\Inkwell\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(5, true),
            'excerpt' => fake()->paragraph(),
            'visibility' => fake()->randomElement(PostVisibility::cases()),
            'published_at' => fake()->boolean(70) ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'visibility' => PostVisibility::Draft,
            'published_at' => null,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'visibility' => PostVisibility::Public,
            'published_at' => now(),
        ]);
    }

    public function subscribersOnly(): static
    {
        return $this->state(fn () => [
            'visibility' => PostVisibility::Subscribers,
            'published_at' => now(),
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn () => [
            'visibility' => PostVisibility::Public,
            'published_at' => fake()->dateTimeBetween('now', '+1 month'),
        ]);
    }
}
