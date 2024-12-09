<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    protected iUserService $userService;

    public function __construct(iUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::query()
            ->with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'teacher');
            })
            ->get();

        if ($users->isEmpty()) {
            return error_response(null, 'No teacher users found', 404);
        }

        return success_response(UserResource::collection($users), "All teacher users");
    }

    public function show(Request $request)
    {
        $userId = $request->id ?? Auth::id();

        $user = User::query()
            ->with('roles')
            ->whereHas('roles', fn($query) => $query->where('name', 'teacher'))
            ->find($userId);

        if (!$user) {
            return error_response(null, 'Teacher user not found', 404);
        }

        return success_response(new UserResource($user), 'Teacher user details');
    }

    public function store(StoreUserRequest $request)
    {
        return $this->userService->store($request);
    }

    public function update(UpdateUserRequest $request)
    {
        return $this->userService->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->userService->destroy($request);
    }
}
