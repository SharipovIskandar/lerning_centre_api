<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'course_id.required' => __('validation.course_id.required'),
            'course_id.exists' => __('validation.course_id_not_exists'),
            'student_id.required' => __('validation.course_id.required'),
            'student_id.exists' => __(''),
        ];
    }
}
