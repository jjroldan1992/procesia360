<?php

namespace App\Http\Controllers;

use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterLinkController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|max:255',
            'url' => 'required|url',
            'orden' => 'nullable|integer',
        ]);

        FooterLink::create($data);
        return back()->with('success', 'Enlace añadido al footer.');
    }

    public function index(Request $request)
    {
        $links = FooterLink::orderBy('orden')->get();
        
        // Si viene un ID por la URL, buscamos ese enlace para editarlo
        $link_edit = null;
        if ($request->has('edit')) {
            $link_edit = FooterLink::find($request->edit);
        }

        return view('admin.web.modulos.linklist.index', compact('links', 'link_edit'));
    }

    public function update(Request $request, FooterLink $linklist) // El nombre del parámetro según tu Route::resource
    {
        $data = $request->validate([
            'titulo' => 'required|max:255',
            'url' => 'required|url',
        ]);

        $linklist->update($data);

        return redirect()->route('admin.web.modulos.linklist.index')->with('success', 'Enlace actualizado correctamente.');
    }

    public function destroy($id)
    {
        FooterLink::destroy($id);
        return back()->with('success', 'Enlace eliminado.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            \App\Models\FooterLink::where('id', $item['id'])->update(['orden' => $item['position']]);
        }

        return response()->json(['status' => 'success']);
    }
}