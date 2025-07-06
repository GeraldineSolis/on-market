@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Panel de Administración</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row text-center mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Productos</h5>
                    <p class="display-6 text-purple">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Órdenes</h5>
                    <p class="display-6 text-purple">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Ingresos Totales</h5>
                    <p class="display-6 text-purple">S/ {{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mb-3">Últimas Órdenes</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'Sin usuario' }}</td>
                <td>S/ {{ number_format($order->total, 2) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($products) && count($products) > 0)
    <h3 class="mt-5 mb-3">Productos Recientes</h3>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h6>{{ $product->name }}</h6>
                    <p class="text-muted small">{{ Str::limit($product->description, 50) }}</p>
                    <span class="fw-bold text-purple mt-auto">S/ {{ number_format($product->price, 2) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection