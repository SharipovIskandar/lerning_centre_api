<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkEvaluationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'homework' => new HomeworkResource($this->homework),
            'teacher' => new UserResource($this->teacher),
            'score' => $this->score,
            'feedback' => $this->feedback,
        ];
    }
}
