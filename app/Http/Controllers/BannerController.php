<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('orden', 'asc')->get();
        return view('admin.web.modulos.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.web.modulos.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072', // Máx 3MB
            'titulo' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('imagen')) {
            $data['imagen_path'] = $request->file('imagen')->store('web/banners', 'public');
        }

        $data['orden'] = Banner::max('orden') + 1;
        $data['activo'] = true;

        Banner::create($data);

        return redirect()->route('admin.web.modulos.banners.index')->with('success', 'Banner añadido correctamente.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->orden as $index => $id) {
            Banner::where('id', $id)->update(['orden' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function destroy(Banner $banner)
    {
        if ($banner->imagen_path) {
            Storage::disk('public')->delete($banner->imagen_path);
        }
        $banner->delete();
        return back()->with('success', 'Banner eliminado.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.web.modulos.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'titulo' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            // 1. Borrar la imagen vieja del disco
            if ($banner->imagen_path) {
                Storage::disk('public')->delete($banner->imagen_path);
            }
            // 2. Guardar la nueva
            $data['imagen_path'] = $request->file('imagen')->store('web/banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.web.modulos.banners.index')->with('success', 'Banner actualizado correctamente.');
    }
}
