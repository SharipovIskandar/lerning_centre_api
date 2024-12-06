<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;

class StudentController extends Controller
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
                $query->where('name', 'student');
            })
            ->get();

        if ($users->isEmpty()) {
            return error_response(null, 'No student users found', 404);
        }

        return success_response(UserResource::collection($users), "All student users");
    }


    public function show(Request $request)
    {
        $user = User::query()
            ->with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })
            ->find($request->id);

        if (!$user) {
            return error_response(null, 'student user not found', 404);
        }

        return success_response(new UserResource($user), 'student user details');
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
