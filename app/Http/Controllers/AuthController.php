<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyAwesomeApp')->plainTextToken;

            return response()->json([
                'token' => $token
            ]);
        }

        return response()->json(['message' => __('messages.invalid_credentials')], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        session()->flush();

        return success_response(__('messages.operation_success'), __('messages.logout_success'));
    }
}
