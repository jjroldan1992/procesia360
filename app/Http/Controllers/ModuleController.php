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
            'route' => 'admin.web.modulos.menu.index'
        ],
        'banners' => [
            'nombre' => 'Banners (Slider)', 
            'funcionalidad' => 'Gestión de imágenes y mensajes destacados en la cabecera.',
            'route' => 'admin.web.modulos.banners.index'
        ],
        'acceso_rapido' => [
            'nombre' => 'Acceso Rápido', 
            'funcionalidad' => 'Configuración de los 3 bloques: Historia, Hazte Hermano y Zona Privada.',
            'route' => 'admin.web.modulos.accesos.index'
        ],
        'calendario' => [
            'nombre' => 'Calendario', 
            'funcionalidad' => 'Gestión de cultos, salidas procesionales y eventos.',
            'route' => 'admin.web.modulos.calendario.index'
        ],
        'grid' => [
            'nombre' => 'Grid de Contenidos', 
            'funcionalidad' => 'Configura cómo se muestran las noticias y páginas recientes.',
            'route' => 'admin.web.modulos.grid.index'
        ],
        'social' => [
            'nombre' => 'Redes Sociales (Social Hub)', 
            'funcionalidad' => 'Gestión de integración con Instagram, Facebook y enlaces sociales.',
            'route' => 'admin.web.modulos.redes.index'
        ],
        'tablon' => [
            'nombre' => 'Tablón Parroquial',
            'route' => 'admin.web.modulos.tablon.index', // El nombre definido en web.php
            'funcionalidad' => 'Gestiona los avisos, horarios de misa y comunicados de la parroquia.',
        ],
        'contacto' => [
            'nombre' => 'Datos de Contacto', 
            'funcionalidad' => 'Configura el mapa, dirección y campos de contacto de la corporación.',
            'route' => 'admin.web.modulos.contacto.index'
        ],
        'link_list' => [
            'nombre' => 'Listado de Enlaces', 
            'funcionalidad' => 'Gestión de enlaces de interés y pies de página (Footer).',
            'route' => 'admin.web.modulos.linklist.index'
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