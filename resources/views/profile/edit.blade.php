@extends('layouts.front')

@section('title', 'Editar perfil')
@section('description', 'Actualizá tus datos personales en RentaCar.')

@section('content')
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <header class="mb-4">
                    <h1 class="fw-bold mb-1">Editar datos personales</h1>
                    <p class="text-muted mb-0">Modificá tu nombre y tu email.</p>
                </header>

                @include('partials.flash')

                <article class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg" aria-hidden="true"></i> Guardar cambios
                                </button>
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
