<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $booking = Booking::where('status', 'confirmed')->first();

        if (! $booking) {
            return;
        }

        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'status' => 'approved',
                'amount' => $booking->total_price,
                'mp_payment_id' => 'DEMO-'.$booking->id,
                'payment_method' => 'account_money',
                'paid_at' => Carbon::parse('2026-07-01 12:00:00'),
            ],
        );
    }
}
