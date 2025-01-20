<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'pinfl' => 'sometimes|required|string|max:14|unique:users,pinfl,' . $this->route('id'),
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'password' => 'sometimes|required|string|min:8',
            'role_id' => 'sometimes|required|exists:roles,id',
            'status' => 'sometimes|nullable|boolean',
            'profile_photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:10480',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('validation.first_name_required'),
            'first_name.string' => __('validation.first_name_string'),
            'first_name.max' => __('validation.first_name_max'),
            'last_name.required' => __('validation.last_name_required'),
            'last_name.string' => __('validation.last_name_string'),
            'last_name.max' => __('validation.last_name_max'),
            'pinfl.required' => __('validation.pinfl_required'),
            'pinfl.string' => __('validation.pinfl_string'),
            'pinfl.unique' => __('validation.pinfl_unique'),
            'pinfl.max' => __('validation.pinfl_max'),
            'email.required' => __('validation.email_required'),
            'email.string' => __('validation.email_string'),
            'email.email' => __('validation.email_email'),
            'email.max' => __('validation.email_max'),
            'email.unique' => __('validation.email_unique'),
            'password.required' => __('validation.password_required'),
            'password.string' => __('validation.password_string'),
            'password.min' => __('validation.password_min'),
            'role_id.required' => __('validation.role_id_required'),
            'role_id.exists' => __('validation.role_id_exists'),
            'status.boolean' => __('validation.status_boolean'),
        ];
    }
}
