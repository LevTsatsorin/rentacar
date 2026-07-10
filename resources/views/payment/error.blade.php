@extends('layouts.front')

@section('title', 'Pago rechazado')
@section('description', 'El pago de tu reserva no pudo completarse.')

@section('content')
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <p class="display-1 text-danger mb-3"><i class="bi bi-x-circle" aria-hidden="true"></i></p>
                <h1 class="fw-bold mb-2">El pago no se completó</h1>
                <p class="text-muted mb-4">Tu reserva sigue registrada como pendiente. Podés reintentar el pago cuando quieras.</p>

                <div class="d-flex justify-content-center gap-2">
                    @if ($booking)
                        <a href="{{ route('payments.checkout', $booking) }}" class="btn btn-primary">
                            <i class="bi bi-arrow-repeat" aria-hidden="true"></i> Reintentar pago
                        </a>
                    @endif
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list-ul" aria-hidden="true"></i> Ver mis reservas
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
