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

    public function updateProfile(UpdateUserRequest $request): \Illuminate\Http\JsonResponse|array
    {
        $user = Auth::user();

        if (!$user) {
            return error_response([], __('validation.user_not_found'), 404);
        }

        $validated = $request->validated();
        $finalPhoto = [];
        if ($request->hasFile('profile_photo')) {
            $existingPhotos = $user->profile_photo ?? [];
            $profilePhotosInput = $request->file('profile_photo');
            $profilePhotosInput = is_array($profilePhotosInput) ? $profilePhotosInput : [$profilePhotosInput];

            foreach ($profilePhotosInput as $profilePhoto) {
                if ($profilePhoto->isValid()) {
                    $profilePhotoName = uniqid('photo_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                    $photoPath = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public');
                    if (preg_match('/photo_[^"]+\.png/', $existingPhotos, $matches)) {
                        $photoName = $matches[0];
                        $finalPhoto = array_merge((array)$photoName, (array)$photoPath);
                    }
                }
            }
            $validated['profile_photo'] = $finalPhoto;
        }
        $user->fill(array_filter($validated));
        $user->save();

        return success_response(new UserResource($user), __('validation.profile_updated'));
    }
    public function clearProfilePhotos(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return error_response([], __('validation.user_not_found'), 404);
        }

        $user->profile_photo = [];
        $user->save();

        return success_response([], __('validation.profile_photos_cleared'));
    }

}
