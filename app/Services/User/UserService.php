<?php

namespace App\Services\User;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserService implements iUserService
{
    public function index()
    {
        return User::query()
            ->with('roles')
            ->paginate(10);
    }

    public function show($id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            $profilePhotoName = uniqid('profile_', true) . '.' . $profilePhoto->getClientOriginalExtension();
            $profilePhotoPath = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public');
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'pinfl' => $validated['pinfl'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'profile_photo' => $profilePhotoPath,
        ]);

        DB::table('user_roles')->insert([
            'user_id' => $user->id,
            'role_id' => $validated['role_id'],
            'status' => 1,
        ]);

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);

        $profilePhotoPath = $user->profile_photo;

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            if ($profilePhoto->isValid()) {
                $profilePhotoName = uniqid('profile_', true) . '.' . $profilePhoto->getClientOriginalExtension();
                $profilePhotoPath = $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public');
            }
        }

        $user->update([
            'first_name' => $validated['first_name'] ?? $user->first_name,
            'last_name' => $validated['last_name'] ?? $user->last_name,
            'pinfl' => $validated['pinfl'] ?? $user->pinfl,
            'email' => $validated['email'] ?? $user->email,
            'password' => !empty($validated['password']) ? bcrypt($validated['password']) : $user->password,
            'profile_photo' => $profilePhotoPath,
        ]);

        if (isset($validated['role_id'])) {
            $user->roles()->sync([
                $validated['role_id'] => ['status' => $validated['status'] ?? 1]
            ]);
        }

        return new UserResource($user);
    }

    public function destroy(Request $users)
    {
        Gate::authorize('delete-user', [$users]);
        $user = User::findOrFail($users->id);

        $user->roles()->detach();
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
