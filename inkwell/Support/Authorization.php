<?php

namespace NiftyCo\Inkwell\Support;

use Illuminate\Support\Facades\Auth;
use NiftyCo\Inkwell\Traits\HasRoles;

class Authorization
{
    public static function check(string $permission): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if (! in_array(HasRoles::class, class_uses_recursive($user))) {
            return false;
        }

        return $user->hasPermission($permission);
    }

    public static function checkAny(array $permissions): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if (! in_array(HasRoles::class, class_uses_recursive($user))) {
            return false;
        }

        return $user->hasAnyPermission($permissions);
    }

    public static function checkAll(array $permissions): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if (! in_array(HasRoles::class, class_uses_recursive($user))) {
            return false;
        }

        return $user->hasAllPermissions($permissions);
    }

    public static function hasRole(string $role): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if (! in_array(HasRoles::class, class_uses_recursive($user))) {
            return false;
        }

        return $user->hasRole($role);
    }

    public static function isAdmin(): bool
    {
        return static::hasRole('admin');
    }

    public static function authorize(string $permission): void
    {
        if (! static::check($permission)) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }

    public static function authorizeAny(array $permissions): void
    {
        if (! static::checkAny($permissions)) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}
