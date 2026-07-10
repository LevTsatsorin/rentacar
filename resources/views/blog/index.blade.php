@extends('layouts.front')

@section('title', 'Blog')
@section('description', 'Consejos para alquilar, novedades de la flota y reviews de modelos.')

@section('content')
    <section class="container py-5">
        <header class="mb-4">
            <h1 class="fw-bold">Blog &amp; Novedades</h1>
            <p class="text-muted">Consejos para tu próximo alquiler, novedades de la flota y reviews.</p>
        </header>

        @if ($categories->isNotEmpty())
            <nav class="mb-4" aria-label="Filtro de categorías">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ ! request('category') ? 'active' : '' }}" href="{{ route('blog.index') }}">Todas</a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link {{ request('category') === $category->slug ? 'active' : '' }}"
                               href="{{ route('blog.index', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        @if ($posts->isEmpty())
            <p class="alert alert-warning">Aún no hay entradas publicadas en esta categoría.</p>
        @else
            <div class="row g-4">
                @foreach ($posts as $post)
                    <article class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            @if ($post->image_url)
                                <img src="{{ $post->image_url }}" class="card-img-top" alt="{{ $post->title }}">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <span class="badge {{ $post->category->badge }} align-self-start mb-2">{{ $post->category->name }}</span>
                                <h2 class="h5 card-title">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark stretched-link">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                <p class="text-muted small mb-3">{{ $post->excerpt }}</p>
                                <footer class="mt-auto small text-muted">
                                    Por {{ $post->author->name }} · {{ $post->created_at->format('d/m/Y') }}
                                </footer>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <nav aria-label="Paginación" class="mt-5">
                {{ $posts->links() }}
            </nav>
        @endif
    </section>
@endsection
