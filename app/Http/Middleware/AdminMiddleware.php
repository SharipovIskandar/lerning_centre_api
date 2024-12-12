<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => __('auth.unauthorized')], 403);
        }

        if ($user->role !== 'admin') {
            return response()->json(['message' => __('auth.forbidden')], 403);
        }

        return $next($request);
    }
}
