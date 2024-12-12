<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'room_id' => 'required|exists:rooms,id',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => __('validation.date_required'),
            'time.required' => __('validation.time_required'),
            'room_id.required' => __('validation.room_id_required'),
            'course_id.required' => __('validation.course_id_required'),
            'teacher_id.required' => __('validation.teacher_id_required'),
        ];
    }
}
