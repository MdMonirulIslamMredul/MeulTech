<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Roles may be a single role or pipe-separated list: "Admin|Super Admin"
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (! $request->user()) {
            abort(403);
        }

        $allowed = explode('|', $roles);

        foreach ($allowed as $role) {
            if ($request->user()->hasRole(trim($role))) {
                return $next($request);
            }
        }

        abort(403);
    }
}
