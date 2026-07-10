<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Plan;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Gestiona el circuito de contratación (reserva) de vehículos por el usuario.
 */
class BookingController extends Controller
{
    /**
     * Muestra el formulario de reserva para un vehículo.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\View\View
     */
    public function create(Car $car): View
    {
        $plans = Plan::active()->orderBy('price_multiplier')->get();

        return view('bookings.create', compact('car', 'plans'));
    }

    /**
     * Registra la reserva en la base de datos.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @param  \App\Models\Car  $car
     * @param  \App\Services\BookingService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBookingRequest $request, Car $car, BookingService $service): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        try {
            $booking = $service->createBooking($user, $car, $request->validated());
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return to_route('bookings.show', $booking)->with('success', '¡Reserva confirmada con éxito!');
    }

    /**
     * Muestra el detalle de una reserva propia del usuario autenticado.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\View\View
     */
    public function show(Booking $booking): View
    {
        abort_unless((int) $booking->user_id === (int) Auth::id(), 403);

        $booking->load('car', 'plan');

        return view('bookings.show', compact('booking'));
    }
}
