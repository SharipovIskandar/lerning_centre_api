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
            'course_id.required' => 'Course ID is required.',
            'room_id.required' => 'Room ID is required.',
            'teacher_id.required' => 'Teacher ID is required.',
            'date.required' => 'Date is required.',
            'time.required' => 'Time is required.',
            'time.date_format' => 'Time must be in the format HH:MM.',
        ];
    }
}
