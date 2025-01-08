<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return error_response([], __('validation.user_not_found'), 404);
        }

        return success_response(new UserResource($user), __('validation.profile_info'));
    }

    public function updateProfile(UpdateUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return error_response([], __('validation.user_not_found'), 404);
        }

        $validated = $request->validated();

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            if ($profilePhoto->isValid()) {
                $profilePhotoName = uniqid('profile_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                $validated['profile_photo'] = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public');
            }
        }

        $user->update(array_filter($validated));

        return success_response(new UserResource($user), __('validation.profile_updated'));
    }
}
