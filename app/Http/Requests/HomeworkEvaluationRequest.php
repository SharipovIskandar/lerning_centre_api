<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeworkEvaluationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'homework_id' => 'required|exists:homeworks,id',
            'student_id' => 'required|exists:users,id',
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ];
    }
}
