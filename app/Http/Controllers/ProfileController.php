<?php

namespace App\Http\Controllers;

use App\Traits\HasFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    use HasFile;
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
            $profilePhotos = is_array($user->profile_photo)
                ? $user->profile_photo
                : json_decode($user->profile_photo, true) ?? [];

            $profilePhotosInput = $request->file('profile_photo');
            $profilePhotosInput = is_array($profilePhotosInput) ? $profilePhotosInput : [$profilePhotosInput];

            foreach ($profilePhotosInput as $profilePhoto) {
                if ($profilePhoto->isValid()) {
                    $profilePhotoName = uniqid('photo_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                    $photoPath = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public');
                    $profilePhotos[] = $photoPath;
                }
            }

            $validated['profile_photo'] = json_encode($profilePhotos);
        }

        $user->update(array_filter($validated));

        return success_response(new UserResource($user), __('validation.profile_updated'));
    }
}
