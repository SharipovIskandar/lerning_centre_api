<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResultResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'exam_id' => $this->exam_id,
            'exam_title' => $this->exam->title,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'score' => $this->score,
            'passed' => $this->passed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
