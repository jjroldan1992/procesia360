<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Parámetros de ordenación por defecto
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $search = $request->get('search');

        // Consulta con filtros
        $posts = Post::when($search, function ($query, $search) {
            return $query->where('titulo', 'like', "%{$search}%")
                        ->orWhere('tipo', 'like', "%{$search}%")
                        ->orWhere('contenido', 'like', "%{$search}%");
        })
        ->orderBy($sort, $direction)
        ->paginate(15) // Añadimos paginación por si la hermandad genera mucho contenido
        ->withQueryString();

        return view('admin.web.paginas.index', compact('posts', 'sort', 'direction', 'search'));
    }

    public function create()
    {
        // Definimos los tipos para pasarlos al select de la vista
        $tipos = ['noticia' => 'Noticia', 'pagina' => 'Página Estática', 'comunicado' => 'Comunicado', 'evento' => 'Evento'];
        return view('admin.web.paginas.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'tipo' => 'required',
            'contenido' => 'required',
            'imagen_destacada' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->titulo);
        $data['publicado'] = $request->has('publicado');
        $data['fecha_publicacion'] = now();

        // Manejo de la imagen
        if ($request->hasFile('imagen_destacada')) {
            $path = $request->file('imagen_destacada')->store('web/posts', 'public');
            $data['imagen_destacada'] = $path;
        }

        Post::create($data);

        return redirect()->route('admin.web.paginas.index')->with('success', 'Contenido guardado con éxito.');
    }

    public function edit(Post $pagina) // Laravel hace el binding automático por el ID
    {
        $tipos = ['noticia' => 'Noticia', 'pagina' => 'Página Estática', 'comunicado' => 'Comunicado', 'evento' => 'Evento'];
        return view('admin.web.paginas.edit', compact('pagina', 'tipos'));
    }

    public function update(Request $request, Post $pagina)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'tipo' => 'required',
            'contenido' => 'required',
            'imagen_destacada' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->titulo);
        $data['publicado'] = $request->has('publicado');

        if ($request->hasFile('imagen_destacada')) {
            // Opcional: Borrar imagen anterior si existía para no llenar el disco
            if ($pagina->imagen_destacada) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pagina->imagen_destacada);
            }
            $data['imagen_destacada'] = $request->file('imagen_destacada')->store('web/posts', 'public');
        }

        $pagina->update($data);

        return redirect()->route('admin.web.paginas.index')->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroy(Post $pagina)
    {
        // Borramos la imagen del disco si existe para no dejar basura
        if ($pagina->imagen_destacada) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pagina->imagen_destacada);
        }

        $pagina->delete();

        return redirect()->route('admin.web.paginas.index')
                        ->with('success', 'Contenido eliminado permanentemente.');
    }
}