<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();

        if ($schedules->isEmpty()) {
            return response()->json(['message' => 'No schedules found'], 404);
        }

        return ScheduleResource::collection($schedules);
    }

    public function store(StoreScheduleRequest $request)
    {
        $validated = $request->validated();

        $schedule = Schedule::create([
            'course_id' => $validated['course_id'],
            'room_id' => $validated['room_id'],
            'teacher_id' => $validated['teacher_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
        ]);

        return new ScheduleResource($schedule);
    }

    public function show($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        return new ScheduleResource($schedule);
    }

    public function update(UpdateScheduleRequest $request, $id)
    {
        $validated = $request->validated();

        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $schedule->update([
            'course_id' => $validated['course_id'],
            'room_id' => $validated['room_id'],
            'teacher_id' => $validated['teacher_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
        ]);

        return new ScheduleResource($schedule);
    }

    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
