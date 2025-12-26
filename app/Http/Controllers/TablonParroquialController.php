<?php

namespace App\Http\Controllers;

use App\Models\TablonParroquial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TablonParroquialController extends Controller
{
    protected $tipos = [
        'misa' => '📍 Horario de Misas',
        'esquela' => '🕯️ Esquela / Difuntos',
        'obra' => '🏗️ Obras y Mantenimiento',
        'campaña' => '🤝 Campaña (Cáritas/Domund)',
        'urgente' => '📢 Aviso Urgente',
        'general' => '📄 Información General'
    ];

    public function index()
    {
        // Ordenamos: primero los fijados, luego por fecha más reciente
        $avisos = TablonParroquial::orderBy('fijado', 'desc')
                                  ->orderBy('fecha_exposicion', 'desc')
                                  ->get();
                                  
        return view('admin.web.modulos.tablon.index', [
            'avisos' => $avisos,
            'tipos' => $this->tipos
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|max:255',
            'contenido' => 'required',
            'tipo' => 'required',
            'fecha_exposicion' => 'required|date',
            'fecha_finalizacion' => 'nullable|date',
            'adjunto' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('adjunto')) {
            $data['adjunto_path'] = $request->file('adjunto')->store('web/tablon', 'public');
        }

        $data['fijado'] = $request->has('fijado');

        TablonParroquial::create($data);

        return back()->with('success', 'Aviso colgado en el tablón.');
    }

    public function destroy($id)
    {
        $aviso = TablonParroquial::findOrFail($id);
        if ($aviso->adjunto_path) {
            Storage::disk('public')->delete($aviso->adjunto_path);
        }
        $aviso->delete();
        return back()->with('success', 'Aviso retirado del tablón.');
    }

    public function edit($id)
    {
        $aviso = TablonParroquial::findOrFail($id);
        return view('admin.web.modulos.tablon.edit', [
            'aviso' => $aviso,
            'tipos' => $this->tipos
        ]);
    }

    public function update(Request $request, $id)
    {
        $aviso = TablonParroquial::findOrFail($id);

        $data = $request->validate([
            'titulo' => 'required|max:255',
            'contenido' => 'required',
            'tipo' => 'required',
            'fecha_exposicion' => 'required|date',
            'fecha_finalizacion' => 'nullable|date',
            'adjunto' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('adjunto')) {
            // Borrar el antiguo si existe
            if ($aviso->adjunto_path) {
                \Storage::disk('public')->delete($aviso->adjunto_path);
            }
            $data['adjunto_path'] = $request->file('adjunto')->store('web/tablon', 'public');
        }

        $data['fijado'] = $request->has('fijado');

        $aviso->update($data);

        return redirect()->route('admin.web.modulos.tablon.index')->with('success', 'Aviso actualizado correctamente.');
    }
}