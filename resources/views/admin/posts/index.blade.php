@extends('layouts.admin')

@section('title', 'Blog')
@section('page-title', 'Gestión del blog')

@section('content')
    <section aria-labelledby="posts-title">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 id="posts-title" class="h4 mb-1">Entradas del blog</h2>
                <p class="text-muted mb-0">Crear, editar, publicar y eliminar entradas.</p>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg" aria-hidden="true"></i> Nueva entrada
            </a>
        </header>

        @if ($posts->isEmpty())
            <p class="alert alert-info">Todavía no hay entradas. Creá la primera.</p>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Imagen</th>
                            <th scope="col">Título</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr class="{{ $post->trashed() ? 'table-secondary' : '' }}">
                                <td style="width: 80px;">
                                    @if ($post->image_url)
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                             class="rounded" style="width: 64px; height: 48px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $post->title }}</td>
                                <td><span class="badge {{ $post->category->badge }}">{{ $post->category->name }}</span></td>
                                <td class="small text-muted">{{ $post->author->name }}</td>
                                <td>
                                    @if ($post->trashed())
                                        <span class="badge text-bg-dark">Eliminada</span>
                                    @elseif ($post->is_active)
                                        <span class="badge text-bg-success">Publicada</span>
                                    @else
                                        <span class="badge text-bg-secondary">Borrador</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if ($post->trashed())
                                        @can('restore', $post)
                                            <form method="POST" action="{{ route('admin.posts.restore', $post) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-arrow-counterclockwise" aria-hidden="true"></i> Restaurar
                                                </button>
                                            </form>
                                        @endcan
                                    @else
                                        @can('update', $post)
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil" aria-hidden="true"></i> Editar
                                            </a>
                                        @endcan
                                        @can('delete', $post)
                                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline"
                                                  onsubmit="return confirm('¿Eliminar esta entrada del blog?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash" aria-hidden="true"></i> Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <nav aria-label="Paginación">
                {{ $posts->links() }}
            </nav>
        @endif
    </section>
@endsection
