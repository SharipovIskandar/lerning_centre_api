<?php

namespace App\Services\User\Contracts;

use App\Http\Requests\CourseRequest;
use App\Http\Requests\RoomRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Mockery\Matcher\Any;

interface iUserService
{
    public function index();
    public function show($id);
    public function store(StoreUserRequest $request);
    public function update(UpdateUserRequest $request, $id);
    public function destroy(Request $users);
}
