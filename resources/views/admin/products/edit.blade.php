@extends('layouts.admin')

@section('title', 'Editar Producto')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-purple">Editar Producto</h2>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @include('admin.products.partials.form', ['product' => $product, 'buttonText' => 'Actualizar Producto'])
    </form>
</div>
@endsection
