<?php

namespace NiftyCo\Inkwell\Database\Seeders;

use Illuminate\Database\Seeder;
use NiftyCo\Inkwell\Models\Permission;
use NiftyCo\Inkwell\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    protected array $permissions = [
        // Posts
        'posts.view',
        'posts.create',
        'posts.edit',
        'posts.delete',
        'posts.publish',

        // Subscribers
        'subscribers.view',
        'subscribers.create',
        'subscribers.edit',
        'subscribers.delete',
        'subscribers.export',

        // Campaigns
        'campaigns.view',
        'campaigns.create',
        'campaigns.edit',
        'campaigns.delete',
        'campaigns.send',

        // Tags
        'tags.view',
        'tags.create',
        'tags.edit',
        'tags.delete',

        // Segments
        'segments.view',
        'segments.create',
        'segments.edit',
        'segments.delete',

        // Settings
        'settings.view',
        'settings.edit',

        // Users
        'users.view',
        'users.create',
        'users.edit',
        'users.delete',

        // Roles
        'roles.view',
        'roles.create',
        'roles.edit',
        'roles.delete',

        // Themes
        'themes.view',
        'themes.switch',
    ];

    protected array $roles = [
        'admin' => [
            'name' => 'Admin',
            'permissions' => '*', // All permissions
        ],
        'editor' => [
            'name' => 'Editor',
            'permissions' => [
                'posts.view',
                'posts.create',
                'posts.edit',
                'posts.delete',
                'posts.publish',
                'subscribers.view',
                'campaigns.view',
                'campaigns.create',
                'campaigns.edit',
                'campaigns.send',
                'tags.view',
                'tags.create',
                'tags.edit',
                'segments.view',
            ],
        ],
        'author' => [
            'name' => 'Author',
            'permissions' => [
                'posts.view',
                'posts.create',
                'posts.edit',
                'subscribers.view',
                'campaigns.view',
                'tags.view',
            ],
        ],
    ];

    public function run(): void
    {
        // Create permissions
        $permissionModels = [];
        foreach ($this->permissions as $slug) {
            $permissionModels[$slug] = Permission::firstOrCreate(
                ['slug' => $slug],
                ['name' => $this->formatName($slug)]
            );
        }

        // Create roles with permissions
        foreach ($this->roles as $slug => $config) {
            $role = Role::firstOrCreate(
                ['slug' => $slug],
                ['name' => $config['name']]
            );

            if ($config['permissions'] === '*') {
                $role->permissions()->sync(array_values($permissionModels));
            } else {
                $role->permissions()->sync(
                    collect($config['permissions'])
                        ->map(fn ($p) => $permissionModels[$p] ?? null)
                        ->filter()
                        ->pluck('id')
                );
            }
        }
    }

    protected function formatName(string $slug): string
    {
        return ucwords(str_replace(['.', '_', '-'], ' ', $slug));
    }
}
