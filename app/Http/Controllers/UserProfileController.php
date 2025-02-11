<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserProfileController extends Controller
{
    public function getUserProfile($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => __('messages.user_not_found')], 404);
        }
    }
}
