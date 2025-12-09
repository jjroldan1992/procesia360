<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario; // Importamos el modelo Usuario para acceder a las propiedades

class HomeController extends Controller
{
    /**
     * Maneja la ruta raíz (/). Decide si mostrar CMS o redirigir al login.
     * Asumimos que el cliente NO eligió el CMS, por lo que redirigimos al login.
     */
    public function index()
    {
        // Si el usuario ya está autenticado, redirigimos al dashboard para evitar bucles.
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        // Si no está autenticado, redirigimos al login, cumpliendo el requisito inicial.
        return redirect()->route('login');
    }

    /**
     * Muestra el dashboard privado después del login.
     * Aquí se aplica la lógica de redirección por Rol (Junta vs. Hermano).
     */
    public function dashboard()
    {
        // 1. Obtener el usuario autenticado (es una instancia del modelo App\Models\Usuario)
        $usuario = Auth::user();

        // 2. Lógica de redirección basada en el rol_id (definido en tu tabla de roles)

        // Roles 1-5: Junta Directiva (Administrador, Hermano Mayor, Secretario, Tesorero, Miembro de Junta)
        if ($usuario->rol_id >= 1 && $usuario->rol_id <= 5) {
            
            // Redirigir al Panel de Gestión (Dashboard de Junta)
            return view('admin.dashboard', ['usuario' => $usuario]);

        } 
        
        // Rol 6: Hermano de Base
        elseif ($usuario->rol_id === 6) {
            
            // Redirigir al Portal del Hermano (Acceso restringido a sus propios datos)
            return view('portal.hermano.dashboard', ['usuario' => $usuario]);
            
        } else {
            // Manejo de errores si el rol no está definido
            Auth::logout();
            return redirect()->route('login')->withErrors('Acceso denegado: Rol de usuario no reconocido.');
        }
    }
    
    // NOTA: Implementar las vistas 'admin.dashboard' y 'portal.hermano.dashboard' en resources/views/
}