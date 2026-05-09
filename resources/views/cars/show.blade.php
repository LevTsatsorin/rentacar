@extends('layouts.front')

@section('title', $car->full_name)
@section('description', Str::limit($car->description, 150))

@section('content')
    <section class="container py-5">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Flota</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $car->full_name }}</li>
            </ol>
        </nav>

        <article class="row g-5">
            <div class="col-lg-7">
                @if ($car->image)
                    <img src="{{ asset('images/' . $car->image) }}" class="img-fluid rounded shadow-sm w-100" alt="{{ $car->full_name }}">
                @else
                    <div class="ratio ratio-16x9 bg-light rounded d-flex align-items-center justify-content-center text-muted">
                        <span><i class="bi bi-image fs-1"></i></span>
                    </div>
                @endif
            </div>

            <div class="col-lg-5">
                <header class="mb-3">
                    <h1 class="fw-bold mb-1">{{ $car->full_name }}</h1>
                    <p class="text-muted mb-0">Modelo {{ $car->year }}</p>
                </header>

                <p class="display-6 fw-bold text-primary mb-1">${{ number_format($car->daily_price, 2) }}</p>
                <p class="text-muted">por día — seguro básico incluido</p>

                <section class="mb-4">
                    <h2 class="h5">Especificaciones</h2>
                    <table class="table table-sm">
                        <tbody>
                            <tr><th scope="row">Marca</th><td>{{ $car->brand }}</td></tr>
                            <tr><th scope="row">Modelo</th><td>{{ $car->model }}</td></tr>
                            <tr><th scope="row">Año</th><td>{{ $car->year }}</td></tr>
                            <tr><th scope="row">Transmisión</th><td>{{ ucfirst($car->transmission) }}</td></tr>
                            <tr><th scope="row">Plazas</th><td>{{ $car->seats }}</td></tr>
                            <tr>
                                <th scope="row">Disponibilidad</th>
                                <td>
                                    @if ($car->is_available)
                                        <span class="badge bg-success">Disponible</span>
                                    @else
                                        <span class="badge bg-secondary">No disponible</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                @if ($car->description)
                    <section class="mb-4">
                        <h2 class="h5">Descripción</h2>
                        <p>{{ $car->description }}</p>
                    </section>
                @endif

            </div>
        </article>
    </section>
@endsection
