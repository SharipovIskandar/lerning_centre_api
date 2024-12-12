<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => __('auth.unauthorized')], 403);
        }

        if ($user->roles->pluck('name')->contains('admin')) {
            return $next($request);
        }

        if (!$user->roles->pluck('name')->contains($role)) {
            return response()->json(['message' => __('auth.forbidden_role', ['role' => $role])], 403);
        }

        return $next($request);
    }
}
