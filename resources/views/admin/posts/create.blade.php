@extends('layouts.admin')

@section('title', 'Nueva entrada')
@section('page-title', 'Nueva entrada del blog')

@section('content')
    <section aria-labelledby="create-title" class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 id="create-title" class="h4 mb-4">Crear entrada</h2>
            @include('admin.posts._form')
        </div>
    </section>
@endsection
