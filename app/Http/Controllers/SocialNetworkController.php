<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialNetwork;

class SocialNetworkController extends Controller
{
    public function index() 
    {
        $redesDefinidas = ['facebook', 'instagram', 'x-twitter', 'youtube', 'tiktok'];
        $redesActivas = SocialNetwork::all()->keyBy('red');
        
        return view('admin.web.modulos.redes.index', compact('redesDefinidas', 'redesActivas'));
    }

    public function update(Request $request) 
    {
        // Validamos que lo que llegue sea un array
        $request->validate([
            'redes' => 'required|array'
        ]);

        foreach($request->redes as $nombreRed => $datos) {
            if(!empty($datos['url'])) {
                \App\Models\SocialNetwork::updateOrCreate(
                    ['red' => $nombreRed], // Condición de búsqueda
                    [
                        'url' => $datos['url'],
                        'mostrar_en_footer' => isset($datos['mostrar_en_footer']),
                        'mostrar_en_contacto' => isset($datos['mostrar_en_contacto'])
                    ]
                );
            } else {
                // Si la URL viene vacía, entendemos que quieren quitar esa red
                \App\Models\SocialNetwork::where('red', $nombreRed)->delete();
            }
        }

        return back()->with('success', 'Redes sociales actualizadas correctamente.');
    }
}
