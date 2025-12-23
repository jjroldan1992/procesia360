<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    // Mantenemos la misma lista para que coincida con la configuración
    protected $modulos = [
        'menu' => [
            'nombre' => 'Menú Principal', 
            'funcionalidad' => 'Configura los enlaces de navegación superior y el orden de las secciones.',
            'route' => 'admin.web.modulos.menu'
        ],
        'banners' => [
            'nombre' => 'Banners (Slider)', 
            'funcionalidad' => 'Gestión de imágenes y mensajes destacados en la cabecera.',
            'route' => 'admin.web.modulos.banners'
        ],
        'acceso_rapido' => [
            'nombre' => 'Acceso Rápido', 
            'funcionalidad' => 'Configuración de los 3 bloques: Historia, Hazte Hermano y Zona Privada.',
            'route' => 'admin.web.modulos.accesos'
        ],
        'calendario' => [
            'nombre' => 'Calendario', 
            'funcionalidad' => 'Gestión de cultos, salidas procesionales y eventos.',
            'route' => 'admin.web.modulos.calendario'
        ],
        'grid' => [
            'nombre' => 'Grid de Contenidos', 
            'funcionalidad' => 'Configura cómo se muestran las noticias y páginas recientes.',
            'route' => 'admin.web.modulos.grid'
        ],
        'social' => [
            'nombre' => 'Redes Sociales (Social Hub)', 
            'funcionalidad' => 'Gestión de integración con Instagram, Facebook y enlaces sociales.',
            'route' => 'admin.web.modulos.social'
        ],
        'parroquia' => [
            'nombre' => 'Tablón Parroquial', 
            'funcionalidad' => 'Espacio informativo para noticias de la Sede Canónica.',
            'route' => 'admin.web.modulos.parroquia'
        ],
        'contacto' => [
            'nombre' => 'Formulario de Contacto', 
            'funcionalidad' => 'Configura el mapa, dirección y campos del formulario.',
            'route' => 'admin.web.modulos.contacto'
        ],
        'link_list' => [
            'nombre' => 'Listado de Enlaces', 
            'funcionalidad' => 'Gestión de enlaces de interés y pies de página (Footer).',
            'route' => 'admin.web.modulos.link_list'
        ]
    ];

    public function index()
    {
        $settings = WebSetting::first();
        
        // Pasamos tanto la estructura de módulos como los ajustes actuales
        return view('admin.web.modulos.index', [
            'modulos' => $this->modulos,
            'settings' => $settings
        ]);
    }

    public function toggle($modulo)
    {
        $settings = WebSetting::first();
        $config = $settings->modulos_config;

        // Cambiamos el estado (si es true pasa a false y viceversa)
        $config[$modulo] = !($config[$modulo] ?? false);

        $settings->update(['modulos_config' => $config]);

        return back()->with('success', 'Estado del módulo actualizado.');
    }
}