<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

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

        dd($validated);
        $profilePhotos = $user->profile_photo ?? [];
        $profilePhotosDirectory = 'profile_photos';
        if (!Storage::disk('public')->exists($profilePhotosDirectory)) {
            Storage::disk('public')->makeDirectory($profilePhotosDirectory);
        }

        if ($request->hasFile('profile_photo')) {
            foreach ($request->file('profile_photo') as $profilePhoto) {
                if ($profilePhoto->isValid()) {
                    $profilePhotoName = uniqid('profile_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                    $photoPath = $profilePhoto->storeAs($profilePhotosDirectory, $profilePhotoName, 'public');
                    $profilePhotos[] = $photoPath;
                }
            }
        }

        $validated['profile_photo'] = $profilePhotos;

        $user->update(array_filter($validated));

        return success_response(new UserResource($user), __('validation.profile_updated'));
    }
}
