@extends('layouts.front')

@section('title', 'Inicio')
@section('description', 'Alquiler de autos en Buenos Aires. Flota moderna, reserva en línea, retiro en sucursal.')

@section('content')
    <section class="hero text-white">
        <div class="container py-5">
            <div class="row align-items-center py-4 g-5">
                <div class="col-lg-8">
                    <h1 class="display-3 fw-bold mb-3">Tu próximo viaje empieza acá.</h1>
                    <p class="lead mb-4 pe-lg-5">Reservá un auto en minutos, retiralo cuando lo necesites, devolvelo sin sorpresas. Sin papeleo eterno, sin letra chica, con atención humana de verdad.</p>
                    <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-car-front-fill"></i> Ver flota
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">Conocenos</a>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-center">
                    <div class="hero-visual">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <header class="mb-4 text-center">
            <h2 class="fw-bold">¿Por qué RentaCar?</h2>
            <p class="text-muted">Tres motivos por los que nuestros clientes vuelven.</p>
        </header>

        <div class="row g-4">
            <article class="col-md-4 text-center">
                <div class="feature-icon mb-3"><i class="bi bi-cash-coin"></i></div>
                <h3 class="h5">Precios claros</h3>
                <p class="text-muted">Una sola tarifa por día. Sin cargos sorpresa al devolver.</p>
            </article>
            <article class="col-md-4 text-center">
                <div class="feature-icon mb-3"><i class="bi bi-shield-check"></i></div>
                <h3 class="h5">Seguro incluido</h3>
                <p class="text-muted">Cobertura básica en todas las reservas. Adicional opcional.</p>
            </article>
            <article class="col-md-4 text-center">
                <div class="feature-icon mb-3"><i class="bi bi-headset"></i></div>
                <h3 class="h5">Atención humana</h3>
                <p class="text-muted">Soporte 24/7 por teléfono y WhatsApp. Atendemos personas, no tickets.</p>
            </article>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container">
            <header class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Los más nuevos de la flota</h2>
                    <p class="text-muted mb-0">Las últimas incorporaciones a nuestra flota.</p>
                </div>
                <a href="{{ route('cars.index') }}" class="btn btn-outline-primary">Ver todos</a>
            </header>

            <div class="row g-4">
                @foreach ($featuredCars as $car)
                    <article class="col-md-4">
                        <div class="card h-100 shadow-sm car-card">
                            @if ($car->image)
                                <img src="{{ asset('images/' . $car->image) }}" class="card-img-top" alt="{{ $car->full_name }}">
                            @endif
                            <div class="card-body">
                                <h3 class="h5 card-title">{{ $car->full_name }}</h3>
                                <p class="text-muted small mb-2">{{ $car->year }} · {{ ucfirst($car->transmission) }} · {{ $car->seats }} plazas</p>
                                <p class="fw-bold text-primary mb-3">${{ number_format($car->daily_price, 2) }} / día</p>
                                <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-primary">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if ($latestPosts->isNotEmpty())
        <section class="container py-5">
            <header class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Del blog</h2>
                    <p class="text-muted mb-0">Consejos, novedades y reviews.</p>
                </div>
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">Todas las entradas</a>
            </header>

            <div class="row g-4">
                @foreach ($latestPosts as $post)
                    <article class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            @if ($post->image)
                                <img src="{{ asset('images/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                            @endif
                            <div class="card-body">
                                <span class="badge {{ $post->category->badge }} mb-2">{{ $post->category->name }}</span>
                                <h3 class="h5 card-title">{{ $post->title }}</h3>
                                <p class="text-muted small">{{ $post->excerpt }}</p>
                                <a href="{{ route('blog.show', $post->slug) }}" class="stretched-link">Leer más</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection
