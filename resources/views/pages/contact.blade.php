@extends('layouts.front')

@section('title', 'Contacto')
@section('description', 'Cómo contactarnos para reservar o consultar.')

@section('content')
    <section class="container py-5">
        <header class="mb-5 text-center">
            <h1 class="fw-bold">Contacto</h1>
            <p class="text-muted lead">Estamos para ayudarte. Escribinos o pasá por la sucursal.</p>
        </header>

        <div class="row g-5">
            <section class="col-lg-5">
                <h2 class="h4 fw-bold mb-4">Datos directos</h2>
                <address class="fst-normal">
                    <p class="mb-3">
                        <strong class="d-block"><i class="bi bi-geo-alt-fill text-primary"></i> Dirección</strong>
                        Av. Corrientes 2037, CABA, Argentina
                    </p>
                    <p class="mb-3">
                        <strong class="d-block"><i class="bi bi-telephone-fill text-primary"></i> Teléfono</strong>
                        +54 11 5032-0076
                    </p>
                    <p class="mb-3">
                        <strong class="d-block"><i class="bi bi-whatsapp text-primary"></i> WhatsApp</strong>
                        +54 9 11 5032-0076
                    </p>
                    <p class="mb-0">
                        <strong class="d-block"><i class="bi bi-envelope-fill text-primary"></i> Email</strong>
                        hola@rentacar.test
                    </p>
                </address>
            </section>

            <section class="col-lg-7">
                <h2 class="h4 fw-bold mb-4">Reservá o consultá</h2>

                <form method="GET" action="{{ route('contact') }}" class="mb-4">
                    <label for="car-select" class="form-label fw-semibold">Elegí un auto</label>
                    <select id="car-select" name="car" class="form-select" onchange="this.form.submit()">
                        <option value="">Sin auto específico — solo consulta</option>
                        @foreach ($availableCars as $car)
                            <option value="{{ $car->id }}" @selected($selectedCar && $selectedCar->id === $car->id)>
                                {{ $car->full_name }} ({{ $car->year }}) — ${{ number_format($car->daily_price, 2) }}/día
                            </option>
                        @endforeach
                    </select>
                    <p class="form-text">Al seleccionar un auto se actualiza la consulta automáticamente.</p>
                </form>

                @if ($selectedCar)
                    <article class="card mb-4 border-primary selected-car">
                        <div class="row g-0">
                            @if ($selectedCar->image)
                                <div class="col-4">
                                    <img src="{{ asset('images/' . $selectedCar->image) }}"
                                         class="img-fluid rounded-start h-100 selected-car-image"
                                         alt="{{ $selectedCar->full_name }}">
                                </div>
                            @endif
                            <div class="{{ $selectedCar->image ? 'col-8' : 'col-12' }}">
                                <div class="card-body">
                                    <span class="badge bg-primary mb-2">Auto seleccionado</span>
                                    <h3 class="h5 card-title mb-1">{{ $selectedCar->full_name }}</h3>
                                    <p class="text-muted small mb-2">
                                        {{ $selectedCar->year }} ·
                                        {{ ucfirst($selectedCar->transmission) }} ·
                                        {{ $selectedCar->seats }} plazas
                                    </p>
                                    <p class="fw-bold text-primary mb-0">
                                        ${{ number_format($selectedCar->daily_price, 2) }} / día
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif

                <form class="card card-body bg-light">
                    @if ($selectedCar)
                        <input type="hidden" name="car_id" value="{{ $selectedCar->id }}">
                    @endif
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea id="message" name="message" class="form-control" rows="5" required>@if ($selectedCar)Hola, quisiera consultar por el alquiler del {{ $selectedCar->full_name }}.@endif</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" disabled>Enviar (demo)</button>
                    <p class="form-text">Formulario de demostración — el envío se implementará más adelante.</p>
                </form>
            </section>
        </div>
    </section>
@endsection
