<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * Lógica de negocio de las reservas (alquileres) de vehículos.
 */
class BookingService
{
    /**
     * Crea una reserva calculando el precio total en el servidor.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Car  $car
     * @param  array<string, mixed>  $data  Datos validados (start_date, end_date, plan_id?).
     * @return \App\Models\Booking
     *
     * @throws \RuntimeException Si el vehículo no está disponible.
     */
    public function createBooking(User $user, Car $car, array $data): Booking
    {
        if (! $car->is_available) {
            throw new \RuntimeException('El vehículo seleccionado no está disponible.');
        }

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);

        $overlaps = Booking::where('car_id', $car->id)
            ->where('status', '!=', 'cancelled')
            ->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start)
            ->exists();

        if ($overlaps) {
            throw new \RuntimeException('El vehículo ya está reservado para las fechas seleccionadas.');
        }

        $days = max(1, $start->diffInDays($end));

        $plan = ! empty($data['plan_id']) ? Plan::find($data['plan_id']) : null;
        $multiplier = $plan ? (float) $plan->price_multiplier : 1.0;

        return $user->bookings()->create([
            'car_id' => $car->id,
            'plan_id' => $plan?->id,
            'start_date' => $start,
            'end_date' => $end,
            'total_price' => round($days * (float) $car->daily_price * $multiplier, 2),
            'status' => config('services.mercadopago.enabled') ? 'pending' : 'confirmed',
        ]);
    }
}
