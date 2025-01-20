<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResultResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'exam_title' => $this->exam->title,
            'user_full_name' => $this->user->first_name . " " . $this->user->last_name,
            'score' => $this->score,
            'passed' => $this->passed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
