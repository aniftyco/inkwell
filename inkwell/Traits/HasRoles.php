<?php

namespace NiftyCo\Inkwell\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use NiftyCo\Inkwell\Models\Permission;
use NiftyCo\Inkwell\Models\Role;

trait HasRoles
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function assignRole(Role|string $role): self
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->syncWithoutDetaching($role);

        return $this;
    }

    public function removeRole(Role|string $role): self
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->detach($role);

        return $this;
    }

    public function hasRole(Role|string $role): bool
    {
        if (is_string($role)) {
            return $this->roles()->where('slug', $role)->exists();
        }

        return $this->roles()->where('roles.id', $role->id)->exists();
    }

    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    public function hasAllRoles(array $roles): bool
    {
        foreach ($roles as $role) {
            if (! $this->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    public function getPermissions(): array
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('slug')
            ->unique()
            ->values()
            ->toArray();
    }

    public function hasPermission(Permission|string $permission): bool
    {
        $slug = $permission instanceof Permission ? $permission->slug : $permission;

        return in_array($slug, $this->getPermissions());
    }

    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (! $this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
