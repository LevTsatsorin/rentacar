@extends('layouts.admin')

@section('title', 'Panel')
@section('page-title', 'Panel de administración')

@section('content')
    <section aria-labelledby="resumen-title">
        <h2 id="resumen-title" class="h4 mb-1">Resumen</h2>
        <p class="text-muted">Vista general del contenido y los usuarios del sitio.</p>

        <div class="row g-4 mt-1">
            <article class="col-sm-6 col-xl-3">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-newspaper"></i></span>
                        <div>
                            <p class="display-6 fw-bold mb-0">{{ $stats['posts'] }}</p>
                            <p class="text-muted mb-0">Entradas de blog</p>
                        </div>
                    </div>
                </div>
            </article>

            <article class="col-sm-6 col-xl-3">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-people"></i></span>
                        <div>
                            <p class="display-6 fw-bold mb-0">{{ $stats['users'] }}</p>
                            <p class="text-muted mb-0">Usuarios</p>
                        </div>
                    </div>
                </div>
            </article>

            <article class="col-sm-6 col-xl-3">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-car-front"></i></span>
                        <div>
                            <p class="display-6 fw-bold mb-0">{{ $stats['cars'] }}</p>
                            <p class="text-muted mb-0">Autos en flota</p>
                        </div>
                    </div>
                </div>
            </article>

            <article class="col-sm-6 col-xl-3">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-calendar-check"></i></span>
                        <div>
                            <p class="display-6 fw-bold mb-0">{{ $stats['bookings'] }}</p>
                            <p class="text-muted mb-0">Alquileres</p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section aria-labelledby="alquileres-title" class="mt-5">
        <h2 id="alquileres-title" class="h4 mb-1">Actividad de alquileres</h2>
        <p class="text-muted">Estadísticas calculadas en tiempo real desde la base de datos.</p>

        <div class="row g-4 mt-1">
            <article class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1"><i class="bi bi-cash-coin text-success" aria-hidden="true"></i> Ingresos totales</p>
                        <p class="h3 fw-bold mb-0">${{ number_format($stats['revenue'], 2) }}</p>
                        <p class="text-muted small mb-0">Reservas confirmadas</p>
                    </div>
                </div>
            </article>

            <article class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1"><i class="bi bi-trophy text-warning" aria-hidden="true"></i> Auto más alquilado</p>
                        @if ($stats['topCar'])
                            <p class="h5 fw-bold mb-0">{{ $stats['topCar']->full_name }}</p>
                            <p class="text-muted small mb-0">{{ $stats['topCarCount'] }} reserva(s)</p>
                        @else
                            <p class="h5 fw-bold mb-0 text-muted">Sin datos</p>
                        @endif
                    </div>
                </div>
            </article>

            <article class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1"><i class="bi bi-calendar-heart text-info" aria-hidden="true"></i> Mes con mayor facturación</p>
                        @if ($stats['topMonth'])
                            <p class="h5 fw-bold mb-0">{{ $stats['topMonth']['label'] }}</p>
                            <p class="text-muted small mb-0">${{ number_format($stats['topMonth']['total'], 2) }}</p>
                        @else
                            <p class="h5 fw-bold mb-0 text-muted">Sin datos</p>
                        @endif
                    </div>
                </div>
            </article>

            <article class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1"><i class="bi bi-star text-primary" aria-hidden="true"></i> Plan más contratado</p>
                        @if ($stats['topPlan'])
                            <p class="h5 fw-bold mb-0">{{ $stats['topPlan']->name }}</p>
                            <p class="text-muted small mb-0">{{ $stats['topPlanCount'] }} reserva(s)</p>
                        @else
                            <p class="h5 fw-bold mb-0 text-muted">Sin datos</p>
                        @endif
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
