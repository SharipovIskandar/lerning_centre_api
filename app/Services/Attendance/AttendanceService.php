<?php

namespace App\Services\Attendance;

use App\Models\Attendance;
use App\Services\Attendance\Contracts\iAttendanceService;
use App\Traits\Crud;
use App\Http\Requests\AttendanceRequest;

class AttendanceService implements iAttendanceService
{
    use Crud;

    protected string $modelClass = Attendance::class;

    public function index()
    {
        return $this->modelClass::all();
    }

    public function show($id)
    {
        return $this->cEdit($id);
    }

    public function store(AttendanceRequest $request)
    {
        return $this->cStore($request);
    }

    public function update(AttendanceRequest $request, $id)
    {
        return $this->cUpdate($request, $id);
    }

    public function destroy($id)
    {
        return $this->cDelete($id);
    }
}
