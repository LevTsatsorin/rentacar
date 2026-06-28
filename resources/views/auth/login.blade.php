@extends('layouts.front')

@section('title', 'Ingresar')
@section('description', 'Iniciá sesión en tu cuenta de RentaCar.')

@section('content')
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="h3 fw-bold mb-4 text-center">Ingresar</h1>

                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required autofocus autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" id="remember" name="remember" value="1" class="form-check-input">
                                <label for="remember" class="form-check-label">Recordarme en este equipo</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>

                        <p class="text-center text-muted mt-4 mb-0">
                            ¿Todavía no tenés cuenta?
                            <a href="{{ route('register') }}">Creá una gratis</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
