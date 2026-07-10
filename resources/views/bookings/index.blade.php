@extends('layouts.front')

@section('title', 'Mis reservas')
@section('description', 'Historial completo de tus alquileres en RentaCar.')

@section('content')
    <header class="page-banner py-5">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h2 fw-bold mb-1">Mis reservas</h1>
                <p class="mb-0 opacity-75">Historial completo de tus alquileres.</p>
            </div>
            <a href="{{ route('profile.show') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left" aria-hidden="true"></i> Volver al perfil
            </a>
        </div>
    </header>

    <section class="container py-5">
        @include('partials.flash')

        @if ($bookings->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <p class="text-muted mb-3">Todavía no tenés reservas registradas.</p>
                    <a href="{{ route('cars.index') }}" class="btn btn-primary">
                        <i class="bi bi-car-front" aria-hidden="true"></i> Explorar la flota
                    </a>
                </div>
            </div>
        @else
            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-branded table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Auto</th>
                                <th scope="col">Plan</th>
                                <th scope="col">Desde</th>
                                <th scope="col">Hasta</th>
                                <th scope="col" class="text-end">Total</th>
                                <th scope="col">Estado</th>
                                <th scope="col"><span class="visually-hidden">Acciones</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->car->full_name }}</td>
                                    <td>{{ $booking->plan?->name ?? '—' }}</td>
                                    <td>{{ $booking->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $booking->end_date->format('d/m/Y') }}</td>
                                    <td class="text-end">${{ number_format($booking->total_price, 2) }}</td>
                                    <td><span class="badge {{ $booking->status_badge }}">{{ $booking->status_label }}</span></td>
                                    <td class="text-end">
                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-secondary">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </section>
@endsection
