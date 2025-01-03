<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use Crud;
    protected iUserService $userService;
    protected $model = User::class;

    public function index()
    {
        $users = User::admin()->with('roles')->paginate(10);

        if ($users->isEmpty()) {
            return error_response(null, __('messages.users_not_found'), 404);
        }

        return success_response(UserResource::collection($users), __('messages.users_found'));
    }

    public function show(Request $request)
    {
        $user = User::admin()->with('roles')->find($request->id);

        if (!$user) {
            return error_response(null, __('messages.user_not_found'), 404);
        }

        return success_response(new UserResource($user), __('messages.user_details'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request);
        return success_response(new UserResource($user), __('messages.user_created'));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->userService->update($request);
        return success_response(new UserResource($user), __('messages.user_updated'));
    }

    public function destroy(Request $request)
    {
        $user = $this->userService->destroy($request);
        return success_response(new UserResource($user), __('messages.user_deleted'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return success_response(new UserResource($user), __('messages.profile_info'));
    }

    public function updateProfile(UpdateUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $student = Auth::user();
        if (!$student) {
            return error_response([], __('messages.user_not_found'), 404);
        }

        $validated = $request->validated();

        $profilePhotoPath = $student->profile_photo;

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            if ($profilePhoto->isValid()) {
                $profilePhotoName = uniqid('profile_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                $profilePhotoPath = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public');
            }
        }

        $student->update([
            'first_name' => $validated['first_name'] ?? $student->first_name,
            'last_name' => $validated['last_name'] ?? $student->last_name,
            'pinfl' => $validated['pinfl'] ?? $student->pinfl,
            'email' => $validated['email'] ?? $student->email,
            'password' => !empty($validated['password']) ? bcrypt($validated['password']) : $student->password,
            'profile_photo' => $profilePhotoPath,
        ]);

        return success_response(new UserResource($student), __('messages.profile_updated'));
    }
}
