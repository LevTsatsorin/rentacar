@extends('layouts.front')

@section('title', 'Reservar ' . $car->full_name)
@section('description', 'Confirmá tu reserva de ' . $car->full_name . ' en RentaCar.')

@section('content')
    <section class="container py-5">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Flota</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cars.show', $car->id) }}">{{ $car->full_name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservar</li>
            </ol>
        </nav>

        <header class="mb-4">
            <h1 class="fw-bold mb-1">Reservá tu {{ $car->full_name }}</h1>
            <p class="text-muted mb-0">Elegí las fechas y el plan de alquiler para confirmar tu reserva.</p>
        </header>

        @include('partials.flash')

        <div class="row g-5">
            <div class="col-lg-5">
                <article class="card border-0 shadow-sm">
                    @if ($car->image)
                        <img src="{{ asset('images/' . $car->image) }}" class="card-img-top" alt="{{ $car->full_name }}">
                    @endif
                    <div class="card-body">
                        <h2 class="h5 mb-1">{{ $car->full_name }}</h2>
                        <p class="text-muted mb-2">Modelo {{ $car->year }} · {{ ucfirst($car->transmission) }} · {{ $car->seats }} plazas</p>
                        <p class="h4 text-primary mb-0">${{ number_format($car->daily_price, 2) }} <small class="text-muted fs-6">por día</small></p>
                    </div>
                </article>
            </div>

            <div class="col-lg-7">
                <form method="POST" action="{{ route('bookings.store', $car) }}" id="booking-form"
                      data-daily-price="{{ $car->daily_price }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="start_date" class="form-label">Fecha de inicio</label>
                            <input type="date" name="start_date" id="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="end_date" class="form-label">Fecha de devolución</label>
                            <input type="date" name="end_date" id="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="plan_id" class="form-label">Plan de alquiler</label>
                            <select name="plan_id" id="plan_id"
                                    class="form-select @error('plan_id') is-invalid @enderror">
                                <option value="" data-multiplier="1">Sin plan adicional (precio base)</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}" data-multiplier="{{ $plan->price_multiplier }}"
                                            @selected(old('plan_id') == $plan->id)>
                                        {{ $plan->name }} (×{{ number_format($plan->price_multiplier, 2) }}) — {{ $plan->description }}
                                    </option>
                                @endforeach
                            </select>
                            @error('plan_id')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="card bg-light border-0 my-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total estimado</span>
                            <output id="total-estimate" class="h4 mb-0 text-primary">$0,00</output>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-check-circle" aria-hidden="true"></i> Confirmar reserva
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const form = document.getElementById('booking-form');
            const dailyPrice = parseFloat(form.dataset.dailyPrice);
            const start = document.getElementById('start_date');
            const end = document.getElementById('end_date');
            const plan = document.getElementById('plan_id');
            const output = document.getElementById('total-estimate');

            function recalculate() {
                const startDate = new Date(start.value);
                const endDate = new Date(end.value);
                let days = 0;
                if (start.value && end.value && endDate > startDate) {
                    days = Math.round((endDate - startDate) / 86400000);
                }
                const multiplier = parseFloat(plan.options[plan.selectedIndex].dataset.multiplier) || 1;
                const total = days * dailyPrice * multiplier;
                output.textContent = '$' + total.toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            [start, end, plan].forEach((el) => el.addEventListener('change', recalculate));
            recalculate();
        })();
    </script>
@endsection
