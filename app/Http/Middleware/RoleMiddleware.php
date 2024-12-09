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

        // Foydalanuvchi tizimga kirmagan bo'lsa, Unauthorized qaytarish
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Agar foydalanuvchi admin bo'lsa, so'rovni davom ettirish
        if ($user->roles->pluck('name')->contains('admin')) {
            return $next($request);
        }

        // Foydalanuvchining kerakli roli borligini tekshirish
        if (!$user->roles->pluck('name')->contains($role)) {
            return response()->json(['message' => "Forbidden cuz you are not a "], 403);
        }

        return $next($request);
    }
}
