<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'time' => $this->time,
            'course' => [
                'id' => $this->course_id,
                'name' => $this->course->name,
            ],
            'room' => [
                'id' => $this->room_id,
                'name' => $this->room->name,
            ],
            'teacher' => [
                'id' => $this->teacher_id,
                'name' => $this->teacher->first_name . ' ' . $this->teacher->last_name,
            ],
        ];
    }
}
