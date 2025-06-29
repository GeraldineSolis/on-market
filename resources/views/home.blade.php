@extends('layouts.app')

@section('title', 'On Market - Inicio')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Bienvenido a On Market</h1>
        <p class="lead mb-4">Descubre productos increíbles al mejor precio</p>
        <a href="{{ route('catalog') }}" class="btn btn-light btn-lg">
            <i class="fas fa-shopping-bag"></i> Ver Catálogo
        </a>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 text-purple">Categorías</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-purple">
                    <div class="card-body text-center">
                        <i class="fas fa-tags fa-3x text-purple mb-3"></i>
                        <h5 class="card-title">{{ ucfirst($category) }}</h5>
                        <a href="{{ route('catalog', ['category' => $category]) }}" class="btn btn-purple">
                            Ver Productos
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 text-purple">Productos Destacados</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-purple mb-0">{{ $product->formatted_price }}</span>
                                <span class="badge bg-secondary">Stock: {{ $product->stock }}</span>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('product.show', $product) }}" class="btn btn-purple btn-sm w-100">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('catalog') }}" class="btn btn-outline-purple btn-lg">
                Ver Todos los Productos <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="feature-box">
                    <i class="fas fa-shipping-fast fa-3x text-purple mb-3"></i>
                    <h4>Envío Rápido</h4>
                    <p class="text-muted">Entregas en 24-48 horas en Lima Metropolitana</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-box">
                    <i class="fas fa-shield-alt fa-3x text-purple mb-3"></i>
                    <h4>Compra Segura</h4>
                    <p class="text-muted">Tus datos y pagos están 100% protegidos</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-box">
                    <i class="fas fa-headset fa-3x text-purple mb-3"></i>
                    <h4>Soporte 24/7</h4>
                    <p class="text-muted">Atención al cliente todos los días del año</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection