@extends('layouts.front')

@section('title', 'Mi perfil')
@section('description', 'Tus datos personales e historial de reservas en RentaCar.')

@section('content')
    <header class="page-banner py-5">
        <div class="container d-flex align-items-center gap-3">
            <span class="avatar-circle">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
            <div>
                <h1 class="h2 fw-bold mb-1">{{ $user->name }}</h1>
                <p class="mb-0 opacity-75">{{ $user->email }}</p>
            </div>
        </div>
    </header>

    <section class="container py-5">
        @include('partials.flash')

        <div class="row g-4">
            <div class="col-lg-4">
                <article class="card card-accent border-0 shadow-sm h-100">
                    <div class="card-header card-header-brand">
                        <h2 class="h5 mb-0"><i class="bi bi-person-vcard" aria-hidden="true"></i> Datos personales</h2>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <dl class="mb-4">
                            <dt class="text-muted fw-normal small">Nombre</dt>
                            <dd class="fw-semibold">{{ $user->name }}</dd>

                            <dt class="text-muted fw-normal small">Email</dt>
                            <dd class="fw-semibold mb-0">{{ $user->email }}</dd>
                        </dl>

                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary w-100 mt-auto">
                            <i class="bi bi-pencil" aria-hidden="true"></i> Editar datos
                        </a>
                    </div>
                </article>
            </div>

            <div class="col-lg-8">
                @unless ($user->isAdmin())
                    <section aria-labelledby="reservas-title" id="mis-reservas">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 id="reservas-title" class="h5 mb-0">Últimas reservas</h2>
                            @if ($bookingsCount > 0)
                                <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-primary">
                                    Ver todas ({{ $bookingsCount }})
                                </a>
                            @endif
                        </div>

                        @if ($recentBookings->isEmpty())
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
                                                <th scope="col">Fechas</th>
                                                <th scope="col" class="text-end">Total</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentBookings as $booking)
                                                <tr>
                                                    <td>{{ $booking->car->full_name }}</td>
                                                    <td>{{ $booking->plan?->name ?? '—' }}</td>
                                                    <td class="text-nowrap">{{ $booking->start_date->format('d/m/Y') }} → {{ $booking->end_date->format('d/m/Y') }}</td>
                                                    <td class="text-end">${{ number_format($booking->total_price, 2) }}</td>
                                                    <td><span class="badge {{ $booking->status_badge }}">{{ $booking->status_label }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </section>
                @else
                    <article class="card card-accent border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center py-5">
                            <span class="feature-icon mb-3"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
                            <h2 class="h5 mb-1">Cuenta de administrador</h2>
                            <p class="text-muted mb-4">Gestioná el contenido y los usuarios desde el panel de administración.</p>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                <i class="bi bi-speedometer2" aria-hidden="true"></i> Ir al panel
                            </a>
                        </div>
                    </article>
                @endunless
            </div>
        </div>
    </section>
@endsection
