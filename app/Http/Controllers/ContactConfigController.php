<?php

namespace App\Http\Controllers;

use App\Models\ContactConfig;
use Illuminate\Http\Request;

class ContactConfigController extends Controller
{
    public function index()
    {
        $config = ContactConfig::firstOrCreate(['id' => 1]);
        return view('admin.web.modulos.contacto.index', compact('config'));
    }

    public function update(Request $request)
    {
        $config = ContactConfig::find(1);
        
        $data = $request->validate([
            'email' => 'nullable|email',
            'google_maps_script' => 'nullable',
            'direccion' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|max:10',
            'municipio' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:255',
            'telefono_llamadas' => 'nullable|max:20',
            'telefono_whatsapp' => 'nullable|max:20',
            'url_lista_difusion' => 'nullable|url',
        ]);

        $config->update($data);

        return back()->with('success', 'Datos de contacto actualizados.');
    }
}
