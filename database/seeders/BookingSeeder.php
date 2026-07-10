<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $cliente = User::where('email', 'cliente@rentacar.test')->firstOrFail();
        $cars = Car::orderBy('id')->take(2)->get();
        $plans = Plan::pluck('id', 'slug');

        $bookings = [
            [
                'car_id' => $cars[0]->id,
                'plan_slug' => 'premium',
                'start_date' => '2026-07-01',
                'end_date' => '2026-07-05',
                'days' => 4,
                'status' => 'confirmed',
            ],
            [
                'car_id' => $cars[1]->id,
                'plan_slug' => 'basico',
                'start_date' => '2026-08-10',
                'end_date' => '2026-08-13',
                'days' => 3,
                'status' => 'pending',
            ],
        ];

        foreach ($bookings as $data) {
            $car = $cars->firstWhere('id', $data['car_id']);
            $plan = Plan::firstWhere('slug', $data['plan_slug']);
            $multiplier = $plan ? (float) $plan->price_multiplier : 1.0;

            Booking::updateOrCreate(
                [
                    'user_id' => $cliente->id,
                    'car_id' => $data['car_id'],
                    'start_date' => $data['start_date'],
                ],
                [
                    'plan_id' => $plans[$data['plan_slug']] ?? null,
                    'end_date' => $data['end_date'],
                    'total_price' => round($data['days'] * (float) $car->daily_price * $multiplier, 2),
                    'status' => $data['status'],
                ],
            );
        }
    }
}
