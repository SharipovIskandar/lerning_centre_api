<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        return app(UserController::class)->store($request);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return app(UserController::class)->update($request, $user);
    }

    public function show(UpdateUserRequest $user)
    {
        return app(UserController::class)->show($user->id);
    }

    public function destroy(Request $user)
    {
        return app(UserController::class)->destroy($user);
    }

    public function index()
    {
        $roleId = Role::where('key', 'teacher')->first()?->id;

        if (!$roleId) {
            return response()->json(['message' => 'No data found'], 404);
        }

        $teachers = User::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();

        if ($teachers->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return UserResource::collection($teachers);
    }
}
