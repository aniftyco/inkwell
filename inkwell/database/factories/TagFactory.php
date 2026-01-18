<?php

namespace NiftyCo\Inkwell\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use NiftyCo\Inkwell\Models\Tag;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'slug' => Str::slug(fake()->unique()->words(2, true)),
        ];
    }
}
