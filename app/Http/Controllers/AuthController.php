<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de inicio de sesión
     */
    public function showLogin(Request $request)
    {
        // Si ya hay una sesión iniciada,
        // enviar directamente al Dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }


    /**
     * Procesar inicio de sesión
     */
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],

        ], [

            'email.required' =>
                'El correo electrónico es obligatorio.',

            'email.email' =>
                'El correo electrónico no es válido.',

            'password.required' =>
                'La contraseña es obligatoria.',

        ]);


        if (Auth::attempt($credenciales)) {

            // Regenerar la sesión por seguridad
            $request->session()->regenerate();

            return redirect()
                ->intended('/dashboard')
                ->with(
                    'success',
                    'Bienvenido al sistema.'
                );
        }


        return back()
            ->withErrors([
                'email' =>
                    'El correo o la contraseña son incorrectos.',
            ])
            ->onlyInput('email');
    }


    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Eliminar la sesión anterior
        $request->session()->invalidate();

        // Generar un nuevo token CSRF
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Sesión cerrada correctamente.'
            );
    }
}