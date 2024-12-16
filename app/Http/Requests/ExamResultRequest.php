<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamResultRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'exam_id' => 'required|exists:exams,id',
            'user_id' => 'required|exists:users,id',
            'score' => 'required|integer|min:0|max:100',
            'passed' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'exam_id.required' => __('examResult.exam_id_required'),
            'exam_id.exists' => __('examResult.exam_id_exists'),
            'user_id.required' => __('examResult.user_id_required'),
            'user_id.exists' => __('examResult.user_id_exists'),
            'score.required' => __('examResult.score_required'),
            'score.integer' => __('examResult.score_integer'),
            'score.min' => __('examResult.score_min'),
            'score.max' => __('examResult.score_max'),
            'passed.required' => __('examResult.passed_required'),
            'passed.boolean' => __('examResult.passed_boolean'),
        ];
    }
}
