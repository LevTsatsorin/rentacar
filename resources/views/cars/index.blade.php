@extends('layouts.front')

@section('title', 'Flota')
@section('description', 'Catálogo completo de autos para alquilar. Filtrá por transmisión, plazas o búsqueda libre.')

@section('content')
    <section class="container py-5">
        <header class="mb-4">
            <h1 class="fw-bold">Nuestra flota</h1>
            <p class="text-muted">Encontrá el auto que necesitás. Disponibilidad en tiempo real.</p>
        </header>

        <form method="GET" action="{{ route('cars.index') }}" class="card card-body bg-light mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="q" class="form-label">Buscar</label>
                    <input type="text" name="q" id="q" class="form-control" placeholder="Marca o modelo" value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <label for="brand" class="form-label">Marca</label>
                    <select name="brand" id="brand" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand }}" @selected(request('brand') === $brand)>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="transmission" class="form-label">Transmisión</label>
                    <select name="transmission" id="transmission" class="form-select">
                        <option value="">Todas</option>
                        <option value="manual" @selected(request('transmission') === 'manual')>Manual</option>
                        <option value="automatic" @selected(request('transmission') === 'automatic')>Automática</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary" type="submit">Filtrar</button>
                </div>
            </div>
        </form>

        @if ($cars->isEmpty())
            <p class="alert alert-warning">No se encontraron autos con esos criterios. Probá con otros filtros.</p>
        @else
            <section class="row g-4">
                @foreach ($cars as $car)
                    <article class="col-sm-6 col-lg-4">
                        <div class="card h-100 shadow-sm car-card">
                            @if ($car->image)
                                <img src="{{ asset('images/' . $car->image) }}" class="card-img-top" alt="{{ $car->full_name }}">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h2 class="h5 card-title">{{ $car->full_name }}</h2>
                                <ul class="list-unstyled small text-muted mb-3">
                                    <li><i class="bi bi-calendar3"></i> {{ $car->year }}</li>
                                    <li><i class="bi bi-gear"></i> {{ ucfirst($car->transmission) }}</li>
                                    <li><i class="bi bi-people"></i> {{ $car->seats }} plazas</li>
                                </ul>
                                <p class="fw-bold text-primary fs-5 mb-3">${{ number_format($car->daily_price, 2) }} <small class="text-muted fw-normal">/ día</small></p>
                                <a href="{{ route('cars.show', $car->id) }}" class="btn btn-outline-primary mt-auto">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>

            <nav aria-label="Paginación" class="mt-5">
                {{ $cars->links() }}
            </nav>
        @endif
    </section>
@endsection
