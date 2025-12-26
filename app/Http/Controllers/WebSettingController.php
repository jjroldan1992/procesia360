<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebSettingController extends Controller
{
    /**
     * Definición centralizada de los módulos para mantener coherencia
     */
    protected $modulos_disponibles = [
        'menu' => 'Menú Principal',
        'banners' => 'Banners',
        'acceso_rapido' => 'Acceso Rápido',
        'calendario' => 'Calendario',
        'grid' => 'Grid de páginas, noticias, comunicados,...',
        'social' => 'Redes Sociales',
        'parroquia' => 'Tablón Parroquial',
        'contacto' => 'Formulario de contacto',
        'link_list' => 'Listado de enlaces'
    ];

    public function index()
    {
        // Recuperamos la configuración o creamos la fila inicial con todos los módulos en 'false' por defecto
        $settings = WebSetting::firstOrCreate(['id' => 1], [
            'nombre_hermandad' => 'Nueva Hermandad',
            'modulos_config' => array_fill_keys(array_keys($this->modulos_disponibles), false)
        ]);

        return view('admin.web.configuracion.index', [
            'settings' => $settings,
            'items' => $this->modulos_disponibles
        ]);
    }

    public function update(Request $request)
    {
        $settings = WebSetting::find(1);
        
        $data = $request->validate([
            'nombre_hermandad' => 'required|string|max:255',
            'template' => 'required|in:campanilleros,saeta,mektub',
            'color_primario' => 'required|string',
            'color_secundario' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024'
        ]);

        // 1. Gestión del Logo
        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('web/config', 'public');
        }

        // 2. Gestión DINÁMICA de Módulos (JSON)
        // Recorremos las claves de nuestro array maestro y miramos si el checkbox vino en el request
        $config = [];
        foreach ($this->modulos_disponibles as $key => $label) {
            $config[$key] = $request->has('mod_' . $key);
        }
        $data['modulos_config'] = $config;

        // 3. Actualización masiva
        $settings->update($data);

        return back()->with('success', 'Configuración de la web actualizada correctamente.');
    }
}