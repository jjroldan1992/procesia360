<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    protected $tipos = [
        'cultos' => 'Cultos',
        'caridad' => 'Caridad',
        'concierto' => 'Concierto',
        'certamen' => 'Certamen',
        'ensayo' => 'Ensayo de Costaleros',
        'convivencia' => 'Convivencia',
        'viaje' => 'Viaje',
        'observaciones' => 'Otros / Observaciones'
    ];

    public function index()
    {
        // Ordenamos por fecha más próxima (los eventos futuros arriba)
        $eventos = Event::orderBy('fecha', 'asc')->get();
        return view('admin.web.modulos.calendario.index', [
            'eventos' => $eventos,
            'tipos' => $this->tipos
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|max:255',
            'fecha' => 'required|date',
            'hora' => 'nullable',
            'tipo' => 'required',
            'lugar' => 'nullable|max:255',
            'observaciones' => 'nullable',
            'cartel' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('cartel')) {
            $data['cartel_path'] = $request->file('cartel')->store('web/calendario', 'public');
        }

        Event::create($data);

        return back()->with('success', 'Evento añadido al calendario.');
    }

    public function destroy(Event $evento)
    {
        if ($evento->cartel_path) {
            Storage::disk('public')->delete($evento->cartel_path);
        }
        $evento->delete();
        return back()->with('success', 'Evento eliminado.');
    }

    public function edit(Event $calendario) // El nombre del parámetro depende de la ruta resource
    {
        $tipos = [
            'cultos' => 'Cultos',
            'caridad' => 'Caridad',
            'concierto' => 'Concierto',
            'certamen' => 'Certamen',
            'ensayo' => 'Ensayo de Costaleros',
            'convivencia' => 'Convivencia',
            'viaje' => 'Viaje',
            'observaciones' => 'Otros / Observaciones'
        ];
        
        return view('admin.web.modulos.calendario.edit', [
            'evento' => $calendario,
            'tipos' => $tipos
        ]);
    }

    public function update(Request $request, Event $calendario)
    {
        $data = $request->validate([
            'titulo' => 'required|max:255',
            'fecha' => 'required|date',
            'hora' => 'nullable',
            'tipo' => 'required',
            'lugar' => 'nullable|max:255',
            'observaciones' => 'nullable',
            'cartel' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('cartel')) {
            if ($calendario->cartel_path) {
                Storage::disk('public')->delete($calendario->cartel_path);
            }
            $data['cartel_path'] = $request->file('cartel')->store('web/calendario', 'public');
        }

        $calendario->update($data);

        return redirect()->route('admin.web.modulos.calendario.index')->with('success', 'Evento actualizado correctamente.');
    }
}