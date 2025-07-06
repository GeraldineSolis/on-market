@extends('layouts.admin')

@section('title', 'Gestión de Productos')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Productos</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Añadir Producto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                @if($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h6>{{ $product->name }}</h6>
                    <p class="text-muted small">{{ Str::limit($product->description, 60) }}</p>
                    <div class="mt-auto">
                        <p class="fw-bold text-purple">S/ {{ number_format($product->price, 2) }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('admin.products.delete', $product) }}" method="POST" onsubmit="return confirm('Estás seguro de eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection