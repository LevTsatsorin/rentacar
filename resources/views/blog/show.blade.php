@extends('layouts.front')

@section('title', $post->title)
@section('description', $post->excerpt)

@section('content')
    <section class="container py-5">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 40) }}</li>
            </ol>
        </nav>

        <article class="mx-auto" style="max-width: 760px;">
            <header class="mb-4">
                <span class="badge {{ $post->category_badge }} mb-3">{{ $post->category }}</span>
                <h1 class="fw-bold mb-3">{{ $post->title }}</h1>
                <p class="text-muted mb-0">
                    Por <strong>{{ $post->author->name }}</strong> ·
                    <time datetime="{{ $post->created_at->toIso8601String() }}">
                        {{ $post->created_at->format('d/m/Y') }}
                    </time>
                </p>
            </header>

            @if ($post->image)
                <img src="{{ asset('images/' . $post->image) }}" class="img-fluid rounded shadow-sm mb-4 w-100" alt="{{ $post->title }}">
            @endif

            @if ($post->excerpt)
                <p class="lead">{{ $post->excerpt }}</p>
            @endif

            <div class="post-content">
                {!! nl2br(e($post->content)) !!}
            </div>

            <footer class="mt-5 pt-4 border-top">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Volver al blog
                </a>
            </footer>
        </article>
    </section>
@endsection
