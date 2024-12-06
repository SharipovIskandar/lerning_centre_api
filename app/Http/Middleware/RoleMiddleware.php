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
            if (!$user->roles->pluck('name')->contains('student')) {
                return response()->json(['message' => 'Forbidden cuz you are not a student'], 403);
            }
        } elseif ($role == 'teacher') {
            if (!$user->roles->pluck('name')->contains('teacher')) {
                return response()->json(['message' => 'Forbidden cuz you are not a teacher'], 403);
            }
        } elseif ($role == 'admin') {
            if (!$user->roles->pluck('name')->contains('admin')) {
                return response()->json(['message' => 'Forbidden cuz you are not an admin'], 403);
            }
        }

        return $next($request);
    }
}
