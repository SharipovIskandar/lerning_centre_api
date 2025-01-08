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
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    use Crud;
    protected $model = User::class;

    public function index(iUserService $userService)
    {
        $users = Cache::remember('admin_users', 60, function () {
            return User::admin()->with('roles')->paginate(10);
        });

        return success_response(UserResource::collection($users), __('validation.users_found'));
    }

    public function show($id, iUserService $userService)
    {
        $user = Cache::remember("admin_user_{$id}", 60, function () use ($id) {
            return User::admin()->with('roles')->findOrFail($id);
        });

        return success_response(new UserResource($user), __('validation.user_details'));
    }

    public function store(StoreUserRequest $request, iUserService $userService)
    {
        $user = $userService->store($request);
        return success_response(new UserResource($user), __('validation.user_created'));
    }

    public function update(UpdateUserRequest $request, iUserService $userService)
    {
        $user = $userService->update($request);
        return success_response(new UserResource($user), __('validation.user_updated'));
    }

    public function destroy(Request $request, iUserService $userService)
    {
        $user = $userService->destroy($request);
        return success_response(new UserResource($user), __('validation.user_deleted'));
    }
}
