<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;

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

    public function show(Request $request)
    {
        $roleId = Role::where('key', 'admin')->first()?->id;

        if (!$roleId) {
            return response()->json(['message' => 'No admin role found'], 404);
        }

        $admin = User::where('id', $request->id)
            ->whereHas('roles', function ($query) use ($roleId) {
                $query->where('role_id', $roleId);
            })
            ->first();

        if (!$admin) {
            return response()->json(['message' => 'User not found or not an admin'], 404);
        }

        return new UserResource($admin);
    }


    public function destroy(Request $users)
    {
        return app(UserController::class)->destroy($users);
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
