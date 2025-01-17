<?php

namespace App\Models;

use App\Traits\DataFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'payment_date',
        'transaction_id',
    ];

    /**
     * The user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
