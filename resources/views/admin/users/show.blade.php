@extends('layouts.admin')

@section('title', 'Detalle de usuario')
@section('page-title', 'Detalle de usuario')

@section('content')
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left" aria-hidden="true"></i> Volver al listado
    </a>

    <section aria-labelledby="user-title" class="mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 id="user-title" class="h4 mb-1">{{ $user->name }}</h2>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                @if ($user->isAdmin())
                    <span class="badge text-bg-primary">Administrador</span>
                @else
                    <span class="badge text-bg-secondary">Usuario</span>
                @endif
            </div>
        </div>
    </section>

    <section aria-labelledby="bookings-title">
        <h3 id="bookings-title" class="h5 mb-3">Servicio contratado (alquileres)</h3>

        @if ($user->bookings->isEmpty())
            <p class="alert alert-info">Este usuario todavía no tiene alquileres registrados.</p>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Auto</th>
                            <th scope="col">Desde</th>
                            <th scope="col">Hasta</th>
                            <th scope="col" class="text-end">Total</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->bookings as $booking)
                            <tr>
                                <td>{{ $booking->car->full_name }}</td>
                                <td>{{ $booking->start_date->format('d/m/Y') }}</td>
                                <td>{{ $booking->end_date->format('d/m/Y') }}</td>
                                <td class="text-end">${{ number_format($booking->total_price, 2) }}</td>
                                <td><span class="badge {{ $booking->status_badge }}">{{ $booking->status_label }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
