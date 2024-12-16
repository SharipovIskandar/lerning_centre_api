<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Store a newly created payment in storage.
     */
    public function store(PaymentRequest $request)
    {
        $payment = Payment::create($request->validated());
        return success_response(new PaymentResource($payment), __('messages.payment_created'), 201);
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        return success_response(new PaymentResource($payment), __('messages.payment_updated'));
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return success_response(null, __('messages.payment_deleted'));
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        return success_response(new PaymentResource($payment), __('messages.payment_retrieved'));
    }
}
