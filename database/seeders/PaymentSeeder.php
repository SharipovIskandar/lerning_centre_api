<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create([
            'user_id' => 1,
            'amount' => 50.00,
            'status' => 'completed',
            'payment_date' => now(),
            'transaction_id' => 'TX12345',
        ]);

        Payment::create([
            'user_id' => 2,
            'amount' => 75.00,
            'status' => 'pending',
            'payment_date' => null,
            'transaction_id' => null,
        ]);
    }
}
