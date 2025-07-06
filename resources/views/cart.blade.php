@extends('layouts.app')

@section('title', 'Carrito de Compras - On Market')

@push('styles')
<style>
input.no-spinners::-webkit-outer-spin-button,
input.no-spinners::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-purple mb-4">
                <i class="fas fa-shopping-cart"></i> Carrito de Compras
            </h1>
            
            @if(Auth::check())
                @if($cartItems->count() > 0)
                    <div class="row">
                        <!-- Cart Items -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-purple text-white">
                                    <h5 class="mb-0">Productos en tu carrito</h5>
                                </div>
                                <div class="card-body p-0">
                                    @foreach($cartItems as $item)
                                    <div class="cart-item border-bottom p-3" data-product-id="{{ $item->product->id }}">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                @if($item->product->image)
                                                    <img src="{{ asset('images/' . $item->product->image) }}" 
                                                         class="img-fluid rounded" alt="{{ $item->product->name }}"
                                                         style="height: 80px; width: 80px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="height: 80px; width: 80px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                <small class="text-muted">{{ $item->product->category }}</small><br>
                                                <span class="text-purple fw-bold">{{ $item->product->formatted_price }}</span>
                                            </div>
                                            <div class="col-md-3">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="quantity-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(this, -1)">-</button>
                                                        <input type="number" name="quantity" class="form-control text-center no-spinners" 
                                                               value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                               onchange="this.form.submit()">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(this, 1)">+</button>
                                                    </div>
                                                </form>
                                                <small class="text-muted">Stock: {{ $item->product->stock }}</small>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="fw-bold">{{ $item->formatted_subtotal }}</span>
                                            </div>
                                            <div class="col-md-1">
                                                <form action="{{ route('cart.remove', $item) }}" method="POST" 
                                                      onsubmit="return confirmRemove(this, '{{ $item->product->id }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cart Summary -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Resumen del Pedido</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>S/ {{ number_format($total, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Envío:</span>
                                        <span class="text-success">Gratis</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-bold">Total:</span>
                                        <span class="fw-bold text-purple h5">S/ {{ number_format($total, 2) }}</span>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('checkout') }}" class="btn btn-purple btn-lg">
                                            <i class="fas fa-credit-card"></i> Proceder al Pago
                                        </a>
                                        <a href="{{ route('catalog') }}" class="btn btn-outline-purple">
                                            <i class="fas fa-arrow-left"></i> Seguir Comprando
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Security Info -->
                            <div class="card mt-3">
                                <div class="card-body text-center">
                                    <i class="fas fa-shield-alt text-success fa-2x mb-2"></i>
                                    <h6>Compra Segura</h6>
                                    <small class="text-muted">
                                        Tus datos están protegidos con encriptación SSL
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty Cart for authenticated user -->
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                        <h3>Tu carrito está vacío</h3>
                        <p class="text-muted mb-4">¡Agrega algunos productos para comenzar a comprar!</p>
                        <a href="{{ route('catalog') }}" class="btn btn-purple btn-lg">
                            <i class="fas fa-shopping-bag"></i> Explorar Productos
                        </a>
                    </div>
                @endif
            @else
                <!-- User not authenticated -->
                <div class="text-center py-5">
                    <i class="fas fa-lock fa-5x text-muted mb-4"></i>
                    <h3>Inicia sesión para ver tu carrito</h3>
                    <p class="text-muted mb-4">Necesitas una cuenta para guardar productos en tu carrito.</p>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="d-grid gap-2">
                                <a href="{{ route('login.form') }}" class="btn btn-purple btn-lg">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                                </a>
                                <a href="{{ route('register.form') }}" class="btn btn-outline-purple btn-lg">
                                    <i class="fas fa-user-plus"></i> Crear Cuenta
                                </a>
                                <a href="{{ route('catalog') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver al Catálogo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Variables de configuración como atributos de datos -->
@if(Auth::check())
    <div id="cart-config" 
         data-user-id="{{ Auth::user()->id }}" 
         data-authenticated="true"
         @if(session('product_removed'))
         data-product-removed="{{ session('product_removed') }}"
         data-session-user="{{ session('user_id') }}"
         @endif
         style="display: none;">
    </div>
@else
    <div id="cart-config" 
         data-authenticated="false" 
         style="display: none;">
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Obtener configuración de los atributos de datos
    const configElement = document.getElementById('cart-config');
    const cartConfig = {
        isAuthenticated: configElement.getAttribute('data-authenticated') === 'true',
        userId: configElement.getAttribute('data-user-id') || null
    };

    if (cartConfig.isAuthenticated) {
        // LIMPIAR localStorage de otros usuarios al cargar la página
        function cleanOtherUsersLocalStorage() {
            const currentUserId = cartConfig.userId;
            const keysToRemove = [];
            
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (key && key.startsWith('addedToCart_user') && !key.includes('_user' + currentUserId + '_')) {
                    keysToRemove.push(key);
                }
            }
            
            keysToRemove.forEach(key => localStorage.removeItem(key));
        }

        cleanOtherUsersLocalStorage();

        // Verificar si se eliminó un producto
        const removedProductId = configElement.getAttribute('data-product-removed');
        const sessionUserId = configElement.getAttribute('data-session-user');
        
        if (removedProductId && sessionUserId === cartConfig.userId) {
            const removedCartKey = 'addedToCart_user' + cartConfig.userId + '_product' + removedProductId;
            localStorage.removeItem(removedCartKey);
        }

        // Marcar productos como "en carrito" en localStorage para este usuario
        document.querySelectorAll('.cart-item').forEach(item => {
            const productId = item.getAttribute('data-product-id');
            const cartKey = 'addedToCart_user' + cartConfig.userId + '_product' + productId;
            localStorage.setItem(cartKey, true);
        });
    }

    function changeQuantity(button, change) {
        const input = button.parentNode.querySelector('input[name="quantity"]');
        const currentValue = parseInt(input.value);
        const newValue = currentValue + change;
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        
        if (newValue >= min && newValue <= max) {
            input.value = newValue;
            input.form.submit();
        }
    }

    function confirmRemove(form, productId) {
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            if (cartConfig.isAuthenticated) {
                const cartKey = 'addedToCart_user' + cartConfig.userId + '_product' + productId;
                localStorage.removeItem(cartKey);
            }
            return true;
        }
        return false;
    }

    // Auto-submit form when quantity changes
    document.querySelectorAll('.quantity-form input[name="quantity"]').forEach(input => {
        input.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush