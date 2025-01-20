<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\Contracts\iUserService;
use App\Traits\Crud;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use Crud;
    protected $modelClass = User::class;

    public function index()
    {
        $users = User::admin()->with('roles')->paginate(10);

        return success_response(UserResource::collection($users), __('messages.users_found')); // Lokalizatsiya qo'shildi
    }

    public function show($id)
    {
        $user = User::admin()->with('roles')->findOrFail($id);

        return success_response(new UserResource($user), __('messages.user_details')); // Lokalizatsiya qo'shildi
    }

    public function store(StoreUserRequest $request, iUserService $userService)
    {
        $user = $userService->store($request);
        return success_response(new UserResource($user), __('messages.user_created')); // Lokalizatsiya qo'shildi
    }

    public function update(UpdateUserRequest $request, iUserService $userService, $id)
    {
        $user = $userService->update($request, $id);
        return success_response(new UserResource($user), __('messages.user_updated')); // Lokalizatsiya qo'shildi
    }

    public function destroy(Request $request, iUserService $userService)
    {
        $user = $userService->destroy($request);
        return success_response(new UserResource($user), __('messages.user_deleted')); // Lokalizatsiya qo'shildi
    }
}
