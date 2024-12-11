<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        if ($users->isEmpty()) {
            return error_response('message', 'No data found', 404);
        }

        return success_response(new UserResource($users), 'Users retrieved successfully.');
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'pinfl' => $validated['pinfl'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        DB::table('user_roles')->insert([
            'user_id' => $user->id,
            'role_id' => $validated['role_id'],
            'status' => 1,
        ]);
        return success_response(new UserResource($user), 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::with('roles')->find($id);

        if (!$user) {
            return error_response('message','User not found', 404);
        }

        return success_response(new UserResource($user), 'User retrieved successfully.');
    }

    public function update(UpdateUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::find($request->id);
        if (!$user) {
            return error_response('message', 'User not found', 404);
        }

        $user->update([
            'first_name' => $validated['first_name'] ?? $user->first_name,
            'last_name' => $validated['last_name'] ?? $user->last_name,
            'pinfl' => $validated['pinfl'] ?? $user->pinfl,
            'email' => $validated['email'] ?? $user->email,
            'password' => !empty($validated['password']) ? bcrypt($validated['password']) : $user->password,
        ]);

        if (isset($validated['role_id'])) {
            $user->roles()->sync([
                $validated['role_id'] => ['status' => $validated['status'] ?? 1]
            ]);
        }

        return success_response(new UserResource($user), 'User updated successfully.');
    }



    public function destroy(Request $users)
    {
        $user = User::find($users->id);

        if (!$user) {
            return error_response('message', 'User not found', 404);
        }

        $user->roles()->detach();
        $user->delete();
        return success_response(new UserResource($user), 'User deleted successfully.');
    }
}
