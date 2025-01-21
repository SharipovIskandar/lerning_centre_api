<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Services\Attendance\Contracts\iAttendanceService;

class AttendanceController extends Controller
{
    protected iAttendanceService $attendanceService;

    public function __construct(iAttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $attendances = $this->attendanceService->index();
        return success_response(AttendanceResource::collection($attendances), 'Attendances fetched successfully');
    }

    public function store(AttendanceRequest $request)
    {
        $attendance = $this->attendanceService->store($request);
        return success_response(new AttendanceResource($attendance), 'Attendance created successfully');
    }

    public function show($id)
    {
        $attendance = $this->attendanceService->show($id);
        return success_response(new AttendanceResource($attendance), 'Attendance fetched successfully');
    }

    public function update(AttendanceRequest $request, $id)
    {
        $attendance = $this->attendanceService->update($request, $id);
        return success_response(new AttendanceResource($attendance), 'Attendance updated successfully');
    }

    public function destroy($id)
    {
        $this->attendanceService->destroy($id);
        return success_response(null, 'Attendance deleted successfully');
    }
}
