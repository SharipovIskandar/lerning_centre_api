<?php

namespace App\Services\User\Contracts;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

interface iUserService
{
    public function index();
    public function show($id);
    public function store(StoreUserRequest $request);
    public function update(UpdateUserRequest $request);
    public function destroy(Request $users);
}
