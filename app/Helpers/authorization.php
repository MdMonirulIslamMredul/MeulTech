<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('user_has_role')) {
    function user_has_role(string $role): bool
    {
        $user = Auth::user();
        return $user ? $user->hasRole($role) : false;
    }
}

if (! function_exists('user_can')) {
    function user_can(string $permission): bool
    {
        $user = Auth::user();
        return $user ? $user->hasPermissionTo($permission) : false;
    }
}
