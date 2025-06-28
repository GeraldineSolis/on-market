@extends('layouts.app')

@section('title', 'Catálogo - On Market')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="text-purple">Catálogo de Productos</h1>
            <p class="text-muted">Encuentra exactamente lo que buscas</p>
        </div>
        <div class="col-md-4">
            <form method="GET" action="{{ route('catalog') }}" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Buscar productos..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-purple ms-2">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-purple text-white">
                    <h5 class="mb-0"><i class="fas fa-filter"></i> Filtros</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('catalog') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Categoría</label>
                            <select name="category" class="form-select" onchange="this.form.submit()">
                                <option value="">Todas las categorías</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ ucfirst($category) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-purple w-100">Aplicar Filtros</button>
                        
                        @if(request('category') || request('search'))
                            <a href="{{ route('catalog') }}" class="btn btn-outline-secondary w-100 mt-2">
                                Limpiar Filtros
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark">{{ ucfirst($product->category) }}</span>
                                </div>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h5 text-purple mb-0">{{ $product->formatted_price }}</span>
                                        <span class="badge bg-secondary">Stock: {{ $product->stock }}</span>
                                    </div>
                                    <div class="d-grid">
                                        <a href="{{ route('product.show', $product) }}" class="btn btn-purple">
                                            <i class="fas fa-eye"></i> Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h3>No se encontraron productos</h3>
                    <p class="text-muted">Intenta con diferentes términos de búsqueda o filtros.</p>
                    <a href="{{ route('catalog') }}" class="btn btn-purple">Ver Todos los Productos</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection