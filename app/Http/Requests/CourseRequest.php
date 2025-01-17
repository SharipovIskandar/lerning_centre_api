<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'name.*' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

}
