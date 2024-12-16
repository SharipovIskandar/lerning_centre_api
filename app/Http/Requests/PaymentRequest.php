<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,failed',
            'payment_date' => 'nullable|date',
            'transaction_id' => 'nullable|string|max:255|unique:payments,transaction_id',
        ];
    }
}
