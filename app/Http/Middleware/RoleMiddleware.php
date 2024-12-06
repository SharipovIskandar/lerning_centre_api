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
        $roleName = $user->roles->pluck('name')->first();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if ($role == 'student') {
            if ($roleName !== 'student' || $user->id !== (int)$request->route('id')) {
                return response()->json(['message' => 'Forbidden cuz u are not student'], 403);
            }
        } elseif ($role == 'teacher') {
            if ($roleName !== 'teacher' || $user->id !== (int)$request->route('id')) {
                return response()->json(['message' => 'Forbidden cuz u are not teacher'], 403);
            }
        } elseif ($role == 'admin') {
            if ($roleName !== 'admin') {
                return response()->json(['message' => 'Forbidden cuz u are not admin'], 403);
            }
        }

        return $next($request);
    }
}
