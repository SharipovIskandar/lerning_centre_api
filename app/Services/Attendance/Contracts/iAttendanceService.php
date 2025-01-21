<?php

namespace App\Services\Attendance\Contracts;

use App\Http\Requests\AttendanceRequest;


interface iAttendanceService
{
    public function index();
    public function show($id);
    public function store(AttendanceRequest $request);
    public function update(AttendanceRequest $request, $id);
    public function destroy($id);
}

