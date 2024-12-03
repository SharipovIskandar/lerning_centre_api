<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return UserResource::collection($users);
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
        return new UserResource($user);
    }

    public function show($id)
    {
        $user = User::with('roles')->find($id);

        if (!$user) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['message' => 'No data found'], 404);
        }

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'pinfl' => $validated['pinfl'],
            'email' => $validated['email'],
            'password' => isset($validated['password']) ? bcrypt($validated['password']) : $user->password,
        ]);

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'No data found'], 404);
        }

        $user->roles()->detach();
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
