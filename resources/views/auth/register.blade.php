@extends('layouts.front')

@section('title', 'Crear cuenta')
@section('description', 'Registrate en RentaCar para gestionar tus alquileres.')

@section('content')
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="h3 fw-bold mb-4 text-center">Crear cuenta</h1>

                        <form method="POST" action="{{ route('register') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre completo</label>
                                <input type="text" id="name" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required autofocus autocomplete="name">
                                @error('name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Repetir contraseña</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-control" required autocomplete="new-password">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
                        </form>

                        <p class="text-center text-muted mt-4 mb-0">
                            ¿Ya tenés cuenta?
                            <a href="{{ route('login') }}">Ingresá</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
