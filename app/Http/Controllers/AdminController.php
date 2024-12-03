<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;

class AdminController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        return app(UserController::class)->store($request);
    }

    public function update(UpdateUserRequest $request)
    {
        return app(UserController::class)->update($request);
    }

    public function show(StoreUserRequest $user)
    {
        return app(UserController::class)->show($user->id);
    }

    public function destroy(User $user)
    {
        return app(UserController::class)->destroy($user);
    }

    public function index()
    {
        $roleId = Role::where('key', 'admin')->first()?->id;

        if (!$roleId) {
            return response()->json(['message' => 'No data found'], 404);
        }

        $admins = User::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();

        if ($admins->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return UserResource::collection($admins);
    }
}
