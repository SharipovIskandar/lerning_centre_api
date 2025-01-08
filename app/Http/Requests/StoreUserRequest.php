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
            'role_id' => 'required|integer|exists:roles,id',
            'profile_photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:10480', // profile_photo uchun fayl validatsiyasi
        ];
    }

//    public function messages()
//    {
//        return [
//            'first_name.required' => __('validation.user.first_name_required'),
//            'first_name.string' => __('validation.user.first_name_string'),
//            'first_name.max' => __('validation.user.first_name_max'),
//            'last_name.required' => __('validation.user.last_name_required'),
//            'last_name.string' => __('validation.user.last_name_string'),
//            'last_name.max' => __('validation.user.last_name_max'),
//            'pinfl.required' => __('validation.user.pinfl_required'),
//            'pinfl.string' => __('validation.user.pinfl_string'),
//            'pinfl.unique' => __('validation.user.pinfl_unique'),
//            'pinfl.max' => __('validation.user.pinfl_max'),
//            'email.required' => __('validation.user.email_required'),
//            'email.string' => __('validation.user.email_string'),
//            'email.email' => __('validation.user.email_email'),
//            'email.max' => __('validation.user.email_max'),
//            'email.unique' => __('validation.user.email_unique'),
//            'password.required' => __('validation.user.password_required'),
//            'password.string' => __('validation.user.password_string'),
//            'password.min' => __('validation.user.password_min'),
//            'role_id.required' => __('validation.user.role_id_required'),
//            'role_id.exists' => __('validation.user.role_id_exists'),
//            'profile_photo.file' => __('validation.user.profile_photo_file'),
//            'profile_photo.mimes' => __('validation.user.profile_photo_mimes'),
//            'profile_photo.max' => __('validation.user.profile_photo_max'),
//        ];
//    }

}
