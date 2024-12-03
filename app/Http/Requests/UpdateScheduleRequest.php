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
            'date.required' => 'Sanani kiriting.',
            'time.required' => 'Vaqtni kiriting.',
            'room_id.required' => 'Xona tanlang.',
            'course_id.required' => 'Kurs tanlang.',
            'teacher_id.required' => 'O\'qituvchini tanlang.',
        ];
    }
}
