@extends('layouts.admin')

@section('title', 'Usuarios')
@section('page-title', 'Usuarios registrados')

@section('content')
    <section aria-labelledby="users-title">
        <h2 id="users-title" class="h4 mb-1">Usuarios</h2>
        <p class="text-muted">Listado de cuentas registradas y la cantidad de alquileres contratados.</p>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col" class="text-center">Alquileres</th>
                        <th scope="col" class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge text-bg-primary">Administrador</span>
                                @else
                                    <span class="badge text-bg-secondary">Usuario</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $user->bookings_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye" aria-hidden="true"></i> Ver detalle
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav aria-label="Paginación">
            {{ $users->links() }}
        </nav>
    </section>
@endsection
