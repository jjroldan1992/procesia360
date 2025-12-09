<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario; // Importamos el modelo Usuario que configuramos

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        // Si el usuario ya está autenticado, redirigir al dashboard para evitar mostrar el login
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        // Devolver la vista resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Procesa la petición de autenticación.
     */
    public function login(Request $request)
    {
        // 1. Validación de los datos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Intentar autenticar contra la tabla 'usuarios'
        // Auth::attempt usa el email y el password (hasheado)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // Regenerar la sesión por seguridad (prevención de Session Fixation)
            $request->session()->regenerate();

            // Redirigir al dashboard después del login exitoso
            return redirect()->intended(route('dashboard'));
        }

        // 3. Fallo de autenticación
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        // Cierra la sesión del usuario autenticado
        Auth::logout();

        // Invalida la sesión actual
        $request->session()->invalidate();

        // Regenera el token CSRF por seguridad
        $request->session()->regenerateToken();

        // Redirige a la página de inicio o login
        return redirect()->route('login');
    }
}