<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'duration' => $this->duration,
            'total_marks' => $this->total_marks,
            'course_id' => $this->course_id,
            'teacher_id' => $this->teacher_id,
            'classroom' => $this->classroom,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
