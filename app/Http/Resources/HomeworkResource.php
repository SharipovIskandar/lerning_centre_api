<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course' => new CourseResource($this->course),
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
        ];
    }
}
