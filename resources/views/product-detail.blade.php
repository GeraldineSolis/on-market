@extends('layouts.app')

@section('title', $product->name . ' - On Market')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog') }}" class="text-decoration-none">Catálogo</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <div class="card">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 400px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <div class="product-info">
                <h1 class="text-purple mb-3">{{ $product->name }}</h1>
                
                <div class="mb-3">
                    <span class="badge bg-light text-dark fs-6 me-2">{{ ucfirst($product->category) }}</span>
                    @if($product->stock > 0)
                        <span class="badge bg-success fs-6">Disponible</span>
                    @else
                        <span class="badge bg-danger fs-6">Agotado</span>
                    @endif
                </div>

                <div class="price-section mb-4">
                    <h2 class="text-purple mb-2">{{ $product->formatted_price }}</h2>
                    <p class="text-muted">Stock disponible: <strong>{{ $product->stock }}</strong> unidades</p>
                </div>

                <div class="description-section mb-4">
                    <h5>Descripción</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <div class="row align-items-end mb-3">
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" 
                                       value="1" min="1" max="{{ $product->stock }}" required>
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-purple btn-lg w-100">
                                    <i class="fas fa-cart-plus"></i> Agregar al Carrito
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Este producto está temporalmente agotado.
                    </div>
                @endif

                <!-- Product Features -->
                <div class="product-features mt-4">
                    <div class="row text-center">
                        <div class="col-4">
                            <i class="fas fa-shipping-fast text-purple mb-2 d-block"></i>
                            <small>Envío Gratis</small>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-undo text-purple mb-2 d-block"></i>
                            <small>30 días devolución</small>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-shield-alt text-purple mb-2 d-block"></i>
                            <small>Garantía</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="related-products mt-5">
        <h3 class="text-purple mb-4">Productos Relacionados</h3>
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    @if($relatedProduct->image)
                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                        <p class="card-text text-muted small">{{ Str::limit($relatedProduct->description, 60) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-purple">{{ $relatedProduct->formatted_price }}</span>
                                <span class="badge bg-secondary">{{ $relatedProduct->stock }}</span>
                            </div>
                            <a href="{{ route('product.show', $relatedProduct) }}" class="btn btn-outline-purple btn-sm w-100">
                                Ver Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.add-to-cart-form');
    const quantityInput = document.getElementById('quantity');
    
    form.addEventListener('submit', function(e) {
        const quantity = parseInt(quantityInput.value);
        const maxStock = parseInt(quantityInput.getAttribute('max'));
        
        if (quantity > maxStock) {
            e.preventDefault();
            alert('La cantidad solicitada excede el stock disponible.');
        }
    });
});
</script>
@endpush
@endsection