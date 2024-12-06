<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userService;

    public function __construct(iUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::query()
            ->with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })
            ->get();

        if ($users->isEmpty()) {
            return error_response(null, 'No admin users found', 404);
        }

        return success_response(UserResource::collection($users), "All admin users");
    }


    public function show(Request $request)
    {
        $user = User::query()
            ->with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })
            ->find($request->id);

        if (!$user) {
            return error_response(null, 'Admin user not found', 404);
        }

        return success_response(new UserResource($user), 'Admin user details');
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
