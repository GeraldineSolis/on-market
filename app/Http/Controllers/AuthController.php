<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $roles = \App\Models\Rol::all();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'id_rol' => 'required|exists:roles,id_rol',
        ]);

        $nombre = $request->input('name');
        $email = $request->input('email');
        $password = bcrypt($request->input('password'));
        $rol = $request->input('id_rol');

        Usuario::create([
            'name' => $nombre,
            'email' => $email,
            'password' => $password,
            'id_rol' => $rol
        ]);

        return redirect()->route('login.form')->with('success', 'Registro exitoso. Inicia sesión.');
    }

    public function showLoginForm()
    {
        $roles = \App\Models\Rol::all();
        return view('auth.login', compact('roles'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->guard('web')->attempt($credentials)) {
            $rol = Auth::user()->rol->valor;

            return match ($rol) {
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('catalog')
            };
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }

}
