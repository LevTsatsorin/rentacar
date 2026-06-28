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
@endsection
