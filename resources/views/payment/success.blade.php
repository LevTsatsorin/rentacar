@extends('layouts.front')

@php($pending = $pending ?? false)

@section('title', $pending ? 'Pago pendiente' : 'Pago aprobado')
@section('description', 'Resultado del pago de tu reserva en RentaCar.')

@section('content')
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                @if ($pending)
                    <p class="display-1 text-warning mb-3"><i class="bi bi-hourglass-split" aria-hidden="true"></i></p>
                    <h1 class="fw-bold mb-2">Pago pendiente</h1>
                    <p class="text-muted mb-4">Tu pago está siendo procesado. Te confirmaremos la reserva cuando se acredite.</p>
                @else
                    <p class="display-1 text-success mb-3"><i class="bi bi-check-circle" aria-hidden="true"></i></p>
                    <h1 class="fw-bold mb-2">¡Pago aprobado!</h1>
                    <p class="text-muted mb-4">Tu reserva quedó confirmada. ¡Gracias por elegir RentaCar!</p>
                @endif

                @if ($booking)
                    <article class="card border-0 shadow-sm text-start mx-auto" style="max-width: 28rem;">
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-5 text-muted fw-normal">Reserva</dt>
                                <dd class="col-7">#{{ $booking->id }}</dd>
                                <dt class="col-5 text-muted fw-normal">Vehículo</dt>
                                <dd class="col-7">{{ $booking->car->full_name }}</dd>
                                <dt class="col-5 text-muted fw-normal">Total</dt>
                                <dd class="col-7 fw-bold text-primary">${{ number_format($booking->total_price, 2) }}</dd>
                            </dl>
                        </div>
                    </article>
                @endif

                <div class="mt-4 d-flex justify-content-center gap-2">
                    <a href="{{ route('bookings.index') }}" class="btn btn-primary">
                        <i class="bi bi-list-ul" aria-hidden="true"></i> Ver mis reservas
                    </a>
                    <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">Explorar la flota</a>
                </div>
            </div>
        </div>
    </section>
@endsection
