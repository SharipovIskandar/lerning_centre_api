<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::query()
            ->paginate(10);

        if ($schedules->isEmpty()) {
            return error_response('message', __('messages.no_schedules_found'), 404);
        }

        return success_response(ScheduleResource::collection($schedules), __('messages.schedules_fetched'));
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

        return success_response(new ScheduleResource($schedule), __('messages.schedule_created'));
    }

    public function show($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return error_response('message', __('messages.schedule_not_found'), 404);
        }

        return success_response(new ScheduleResource($schedule), __('messages.schedule_fetched'));
    }

    public function update(UpdateScheduleRequest $request, $id)
    {
        $validated = $request->validated();

        $schedule = Schedule::find($id);

        if (!$schedule) {
            return error_response('message', __('messages.schedule_not_found'), 404);
        }

        $schedule->update([
            'course_id' => $validated['course_id'],
            'room_id' => $validated['room_id'],
            'teacher_id' => $validated['teacher_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
        ]);

        return success_response(new ScheduleResource($schedule), __('messages.schedule_updated'));
    }

    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return error_response('message', __('messages.schedule_not_found'), 404);
        }

        $schedule->delete();

        return success_response(new ScheduleResource($schedule), __('messages.schedule_deleted'));
    }
}
