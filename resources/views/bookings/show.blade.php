@extends('layouts.front')

@section('title', 'Reserva #' . $booking->id)
@section('description', 'Detalle de tu reserva en RentaCar.')

@section('content')
    <section class="container py-5">
        @include('partials.flash')

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm">
                    <header class="card-header bg-white border-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h1 class="h3 fw-bold mb-1">
                                    {{ $booking->status === 'confirmed' ? '¡Reserva confirmada!' : 'Reserva registrada' }}
                                </h1>
                                <p class="text-muted mb-0">Comprobante #{{ $booking->id }}</p>
                            </div>
                            <span class="badge {{ $booking->status_badge }} fs-6">{{ $booking->status_label }}</span>
                        </div>
                    </header>

                    <div class="card-body px-4">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted fw-normal">Vehículo</dt>
                            <dd class="col-sm-8 fw-semibold">{{ $booking->car->full_name }} ({{ $booking->car->year }})</dd>

                            <dt class="col-sm-4 text-muted fw-normal">Plan</dt>
                            <dd class="col-sm-8">{{ $booking->plan?->name ?? 'Sin plan adicional' }}</dd>

                            <dt class="col-sm-4 text-muted fw-normal">Desde</dt>
                            <dd class="col-sm-8">{{ $booking->start_date->format('d/m/Y') }}</dd>

                            <dt class="col-sm-4 text-muted fw-normal">Hasta</dt>
                            <dd class="col-sm-8">{{ $booking->end_date->format('d/m/Y') }}</dd>

                            <dt class="col-sm-4 text-muted fw-normal">Total</dt>
                            <dd class="col-sm-8 h4 text-primary mb-0">${{ number_format($booking->total_price, 2) }}</dd>
                        </dl>
                    </div>

                    <footer class="card-footer bg-white border-0 px-4 pb-4 d-flex flex-wrap gap-2">
                        @if ($booking->status === 'pending' && config('services.mercadopago.enabled'))
                            <a href="{{ route('payments.checkout', $booking) }}" class="btn btn-primary">
                                <i class="bi bi-credit-card" aria-hidden="true"></i> Pagar con MercadoPago
                            </a>
                            @unless (request()->secure())
                                <form method="POST" action="{{ route('payments.refresh', $booking) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="bi bi-arrow-clockwise" aria-hidden="true"></i> Ya pagué — verificar estado
                                    </button>
                                </form>
                            @endunless
                        @endif
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-list-ul" aria-hidden="true"></i> Ver mis reservas
                        </a>
                    </footer>
                </article>
            </div>
        </div>
    </section>
@endsection
