@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Iniciar Sesión</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-purple w-100">Ingresar</button>
        
        <div class="text-center mt-3">
            <a href="{{ route('register.form') }}" class="btn btn-outline-secondary">
                Crear una cuenta
            </a>
        </div>
    </form>
</div>
@endsection
