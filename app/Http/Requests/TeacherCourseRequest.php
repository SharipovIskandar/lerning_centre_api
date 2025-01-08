<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'nullable|exists:teachers,id',
        ];
    }

//    public function messages(): array
//    {
//        return [
//            'course_id.required' => 'Kursni tanlash majburiy!',
//            'course_id.exists' => 'Berilgan kurs mavjud emas!',
//            'student_id.exists' => 'O\'quvchi mavjud emas!',
//            'teacher_id.exists' => 'O\'qituvchi mavjud emas!',
//        ];
//    }
}
