@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Crear Cuenta</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="id_rol" class="form-label">Rol</label>
            <select name="id_rol" id="rol" class="form-select" required onchange="toggleCodigo(this)">
                <option value="">Seleccionar...</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                        {{ ucfirst($rol->valor) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="codigo-bibliotecario" style="display: none;">
            <label for="code" class="form-label">Código de Bibliotecarix</label>
            <input type="text" name="code" class="form-control" value="{{ old('code') }}">
        </div>

        <button type="submit" class="btn btn-purple w-100">Registrarse</button>
    </form>
</div>

<script>
    function toggleCodigo(select) {
        const selectedText = select.options[select.selectedIndex].text.toLowerCase();
        const div = document.getElementById('codigo-bibliotecario');
        div.style.display = selectedText === 'bibliotecarix' ? 'block' : 'none';
    }

    // Ejecutar al cargar si ya estaba seleccionado
    document.addEventListener('DOMContentLoaded', function () {
        toggleCodigo(document.getElementById('rol'));
    });
</script>
@endsection
