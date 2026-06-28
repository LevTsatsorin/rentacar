@extends('layouts.admin')

@section('title', 'Editar entrada')
@section('page-title', 'Editar entrada del blog')

@section('content')
    <section aria-labelledby="edit-title" class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 id="edit-title" class="h4 mb-4">Editar: {{ $post->title }}</h2>
            @include('admin.posts._form')
        </div>
    </section>
@endsection
