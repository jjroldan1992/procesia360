<?php

namespace App\Http\Controllers;

use App\Models\FastAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FastAccessController extends Controller
{
    public function index()
    {
        $accesos = FastAccess::orderBy('orden', 'asc')->get();
        return view('admin.web.modulos.accesos.index', compact('accesos'));
    }

    public function store(Request $request)
    {
        // Verificar si ya existen 3
        if (FastAccess::count() >= 3) {
            return back()->with('error', 'Solo se permiten un máximo de 3 accesos rápidos.');
        }

        $request->validate([
            'imagen' => 'required|image|max:2048',
            'url' => 'required',
            'alt_text' => 'required|max:255'
        ]);

        $path = $request->file('imagen')->store('web/accesos', 'public');

        FastAccess::create([
            'imagen_path' => $path,
            'url' => $request->url,
            'alt_text' => $request->alt_text,
            'orden' => FastAccess::max('orden') + 1
        ]);

        return back()->with('success', 'Acceso rápido creado.');
    }

    public function destroy(FastAccess $acceso)
    {
        Storage::disk('public')->delete($acceso->imagen_path);
        $acceso->delete();
        return back()->with('success', 'Acceso eliminado.');
    }

    public function edit(FastAccess $acceso)
    {
        return view('admin.web.modulos.accesos.edit', compact('acceso'));
    }

    public function update(Request $request, FastAccess $acceso)
    {
        $request->validate([
            'imagen' => 'nullable|image|max:2048',
            'url' => 'required',
            'alt_text' => 'required|max:255'
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            // Borramos la imagen antigua
            if ($acceso->imagen_path) {
                \Storage::disk('public')->delete($acceso->imagen_path);
            }
            $data['imagen_path'] = $request->file('imagen')->store('web/accesos', 'public');
        }

        $acceso->update($data);

        return redirect()->route('admin.web.modulos.accesos.index')->with('success', 'Acceso actualizado.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->orden as $index => $id) {
            FastAccess::where('id', $id)->update(['orden' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }
}