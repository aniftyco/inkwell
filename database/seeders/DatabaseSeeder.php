<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => env('ADMIN_NAME', 'Arthur Inkwell'),
            'email' => env('ADMIN_EMAIL', 'inkwell@example.com'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'hunter2')),
            'url' => env('ADMIN_URL', null),
        ]);

        Post::factory(1)->create([
            'user_id' => $user->id,
            'title' => 'Welcome to Inkwell',
            'slug' => 'welcome',
            'body' => 'This is your first post in Inkwell. Feel free to edit it or create new posts.',
            'excerpt' => 'This is your first post in Inkwell.',
            'published_at' => now(),
        ]);
    }
}
