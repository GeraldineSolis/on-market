@extends('layouts.app')

@section('title', 'Checkout - On Market')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-purple mb-4">
                <i class="fas fa-credit-card"></i> Finalizar Compra
            </h1>
            
            <div class="row">
                <!-- Customer Information Form -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-purple text-white">
                            <h5 class="mb-0">Información de Envío</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('order.process') }}" method="POST" id="checkout-form">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="customer_name" class="form-label">Nombre Completo *</label>
                                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                               id="customer_name" name="customer_name" 
                                               value="{{ old('customer_name') }}" required>
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_email" class="form-label">Correo Electrónico *</label>
                                        <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                               id="customer_email" name="customer_email" 
                                               value="{{ old('customer_email') }}" required>
                                        @error('customer_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_phone" class="form-label">Teléfono *</label>
                                        <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" 
                                               id="customer_phone" name="customer_phone" 
                                               value="{{ old('customer_phone') }}" required>
                                        @error('customer_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">Dirección Completa *</label>
                                    <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                              id="customer_address" name="customer_address" rows="3" 
                                              required>{{ old('customer_address') }}</textarea>
                                    @error('customer_address')
                                        <div class="invalid-feedback">{{ $message }}</div>