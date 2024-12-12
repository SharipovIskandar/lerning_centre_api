<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'room_id' => 'required|exists:rooms,id',
            'teacher_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'course_id.required' => __('validation.schedule.course_id_required'),
            'course_id.exists' => __('validation.schedule.course_id_exists'),
            'room_id.required' => __('validation.schedule.room_id_required'),
            'room_id.exists' => __('validation.schedule.room_id_exists'),
            'teacher_id.required' => __('validation.schedule.teacher_id_required'),
            'teacher_id.exists' => __('validation.schedule.teacher_id_exists'),
            'date.required' => __('validation.schedule.date_required'),
            'date.date' => __('validation.schedule.date_date'),
            'time.required' => __('validation.schedule.time_required'),
            'time.date_format' => __('validation.schedule.time_date_format'),
        ];
    }

}
