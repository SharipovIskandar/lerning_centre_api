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
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($role == 'student') {
            if ($user->role !== 'student' || $user->id !== (int)$request->route('id')) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } elseif ($role == 'teacher') {
            if ($user->role !== 'teacher' || $user->id !== (int)$request->route('id')) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } elseif ($role == 'admin') {
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        }

        return $next($request);
    }
}
