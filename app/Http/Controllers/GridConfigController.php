<?php

namespace App\Http\Controllers;

use App\Models\GridConfig;
use Illuminate\Http\Request;

class GridConfigController extends Controller
{
    public function index()
    {
        // Obtenemos la primera configuración o creamos una vacía si no existe
        $config = GridConfig::firstOrCreate(['id' => 1]);
        
        $tiposDisponibles = [
            'noticia' => 'Noticias',
            'comunicado' => 'Comunicados',
            'evento' => 'Eventos',
            'pagina' => 'Páginas Estáticas'
        ];

        return view('admin.web.modulos.grid.index', compact('config', 'tiposDisponibles'));
    }

    public function update(Request $request)
    {
        $config = GridConfig::find(1);
        
        $request->validate([
            'cantidad_mostrar' => 'required|integer|min:1|max:20',
            'tipos_permitidos' => 'array'
        ]);

        $config->update([
            'tipos_permitidos' => $request->tipos_permitidos,
            'cantidad_mostrar' => $request->cantidad_mostrar,
            'titulo_seccion' => $request->titulo_seccion
        ]);

        return back()->with('success', 'Configuración del Grid actualizada.');
    }
}