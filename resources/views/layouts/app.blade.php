<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'On Market - Tu tienda online')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #6f42c1;
            --light-purple: #8a63d2;
            --dark-purple: #5a2d91;
            --accent-purple: #9b59b6;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-purple) !important;
            font-size: 1.5rem;
        }
        
        .btn-purple {
            background-color: var(--primary-purple);
            border-color: var(--primary-purple);
            color: white;
        }
        
        .btn-purple:hover {
            background-color: var(--dark-purple);
            border-color: var(--dark-purple);
            color: white;
        }
        
        .text-purple {
            color: var(--primary-purple) !important;
        }
        
        .bg-purple {
            background-color: var(--primary-purple) !important;
        }
        
        .border-purple {
            border-color: var(--primary-purple) !important;
        }
        
        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 8px 25px rgba(111, 66, 193, 0.15);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-purple), var(--accent-purple));
            color: white;
            padding: 100px 0;
        }
        
        .footer {
            background-color: var(--dark-purple);
            color: white;
            padding: 40px 0;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .badge-cart {
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            position: absolute;
            top: -8px;
            right: -8px;
        }
        
        .cart-icon {
            position: relative;
            display: inline-block;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }

        .user-name {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-store text-purple"></i> On Market
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog') }}">Catálogo</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="{{ route('cart') }}">
                            <i class="fas fa-shopping-cart"></i>
                            @if(Auth::check())
                                @php
                                    // Obtener el session_id específico del usuario
                                    $userSessionKey = 'cart_session_user_' . Auth::user()->id;
                                    $userSessionId = session($userSessionKey, 'user_' . Auth::user()->id . '_default');
                                    $cartCount = \App\Models\CartItem::where('session_id', $userSessionId)->sum('quantity');
                                @endphp
                                @if($cartCount > 0)
                                    <span class="badge-cart">{{ $cartCount }}</span>
                                @endif
                            @endif
                        </a>
                    </li>
                    
                    <!-- Dropdown de usuario -->
                    <li class="nav-item">
                        <div class="dropdown">
                            @auth
                                <!-- Usuario autenticado -->
                                <span class="nav-link dropdown-toggle d-flex align-items-center" style="cursor: pointer;">
                                    <i class="fa-solid fa-user me-2"></i>
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                </span>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li class="dropdown-item-text">
                                        <strong>{{ Auth::user()->name }}</strong><br>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-user me-2"></i> Mi Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-box me-2"></i> Mis Pedidos
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            @else
                                <!-- Usuario no autenticado -->
                                <span class="nav-link dropdown-toggle" style="cursor: pointer;">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login.form') }}">
                                            <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesión
                                        </a>
                                    </li> 
                                    <li>
                                        <a class="dropdown-item" href="{{ route('register.form') }}">
                                            <i class="fas fa-user-plus me-2"></i> Registrar
                                        </a>
                                    </li> 
                                </ul>
                            @endauth
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-store"></i> On Market</h5>
                    <p>Tu tienda online de confianza. Encuentra los mejores productos al mejor precio.</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Inicio</a></li>
                        <li><a href="{{ route('catalog') }}" class="text-light text-decoration-none">Catálogo</a></li>
                        <li><a href="{{ route('cart') }}" class="text-light text-decoration-none">Carrito</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p><i class="fas fa-envelope"></i> info@onmarket.com</p>
                    <p><i class="fas fa-phone"></i> +51 999 888 777</p>
                    <p><i class="fas fa-map-marker-alt"></i> Lima, Perú</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} On Market. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>