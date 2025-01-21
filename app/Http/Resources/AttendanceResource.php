<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => new CourseResource($this->course),
            'student' => new UserResource($this->student),
            'date' => $this->date,
        ];
    }
}

