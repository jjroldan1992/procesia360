<?php

namespace App\Http\Controllers;

use App\Models\NavMenu;
use Illuminate\Http\Request;

class NavMenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'orden');
        $direction = $request->get('direction', 'asc');

        $enlaces = NavMenu::when($search, function($query, $search) {
            return $query->where('nombre', 'like', "%{$search}%");
        })
        ->orderBy($sort, $direction)
        ->get();

        return view('admin.web.modulos.menu.index', compact('enlaces', 'search', 'sort', 'direction'));
    }

    public function create()
    {
        // Obtenemos todos los posts de tipo 'pagina' para que el usuario pueda enlazarlos fácilmente
        $paginas = \App\Models\Post::where('publicado', true)
                    ->orderBy('titulo', 'asc')
                    ->get();

        return view('admin.web.modulos.menu.create', compact('paginas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|max:255',
            'url' => 'required',
        ]);

        // Buscamos el orden más alto actual y le sumamos 1
        $data['orden'] = \App\Models\NavMenu::max('orden') + 1;
        $data['activo'] = true;

        NavMenu::create($data);

        return redirect()->route('admin.web.modulos.menu.index')->with('success', 'Enlace añadido al final del menú.');
    }

    // Muestra el formulario de edición
    public function edit(NavMenu $menu)
    {
        // Obtenemos las páginas para el desplegable de ayuda
        $paginas = \App\Models\Post::where('publicado', true)->orderBy('titulo', 'asc')->get();
        
        return view('admin.web.modulos.menu.edit', compact('menu', 'paginas'));
    }

    // Procesa la actualización
    public function update(Request $request, NavMenu $menu)
    {
        $data = $request->validate([
            'nombre' => 'required|max:255',
            'url' => 'required',
            'activo' => 'boolean'
        ]);

        $data['activo'] = $request->has('activo');

        $menu->update($data);

        return redirect()->route('admin.web.modulos.menu.index')
                        ->with('success', 'Enlace actualizado correctamente.');
    }

    // Elimina el ítem (y sus hijos por cascada)
    public function destroy(NavMenu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.web.modulos.menu.index')
                        ->with('success', 'Enlace y sus submenús eliminados.');
    }

    public function reorder(Request $request)
    {
        $menuTree = $request->input('menu'); // Recibimos el árbol jerárquico

        $this->updateMenuHierarchy($menuTree);

        return response()->json(['success' => true]);
    }

    private function updateMenuHierarchy($items, $parentId = null)
    {
        foreach ($items as $index => $item) {
            $menu = \App\Models\NavMenu::find($item['id']);
            $menu->orden = $index + 1;
            $menu->parent_id = $parentId;
            $menu->save();

            if (isset($item['children'])) {
                $this->updateMenuHierarchy($item['children'], $menu->id);
            }
        }
    }
}