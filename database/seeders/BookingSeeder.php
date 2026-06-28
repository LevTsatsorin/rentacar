<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $cliente = User::where('email', 'cliente@rentacar.test')->firstOrFail();
        $cars = Car::orderBy('id')->take(2)->get();

        $bookings = [
            [
                'car_id' => $cars[0]->id,
                'start_date' => '2026-07-01',
                'end_date' => '2026-07-05',
                'days' => 4,
                'status' => 'confirmed',
            ],
            [
                'car_id' => $cars[1]->id,
                'start_date' => '2026-08-10',
                'end_date' => '2026-08-13',
                'days' => 3,
                'status' => 'pending',
            ],
        ];

        foreach ($bookings as $data) {
            $car = $cars->firstWhere('id', $data['car_id']);

            Booking::updateOrCreate(
                [
                    'user_id' => $cliente->id,
                    'car_id' => $data['car_id'],
                    'start_date' => $data['start_date'],
                ],
                [
                    'end_date' => $data['end_date'],
                    'total_price' => $data['days'] * (float) $car->daily_price,
                    'status' => $data['status'],
                ],
            );
        }
    }
}
