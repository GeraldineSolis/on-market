@extends('layouts.admin')

@section('title', 'Añadir Producto')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-purple">Añadir Nuevo Producto</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('admin.products.partials.form', ['product' => null, 'buttonText' => 'Crear Producto'])
    </form>
</div>
@endsection
