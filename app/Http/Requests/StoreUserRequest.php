<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'pinfl' => 'required|string|unique:users|max:14',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'profile_photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:10480', // profile_photo uchun fayl validatsiyasi
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a string.',
            'first_name.max' => 'First name must not exceed 255 characters.',
            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a string.',
            'last_name.max' => 'Last name must not exceed 255 characters.',
            'pinfl.required' => 'Pinfl is required.',
            'pinfl.string' => 'Pinfl must be a string.',
            'pinfl.unique' => 'Pinfl must be unique.',
            'pinfl.max' => 'Pinfl must not exceed 14 characters.',
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a string.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'Email must be unique.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters long.',
            'role_id.required' => 'Role is required.',
            'role_id.exists' => 'The selected role is invalid.',
            'profile_photo.file' => 'Profile photo must be a file.',
            'profile_photo.mimes' => 'Profile photo must be a JPEG, PNG, JPG, or GIF image.',
            'profile_photo.max' => 'Profile photo must not be larger than 10MB.',
        ];
    }
}
