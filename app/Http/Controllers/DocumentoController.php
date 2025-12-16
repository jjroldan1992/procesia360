<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DocumentoController extends Controller
{
    private $basePath = 'documentos';

    public function index($path = null)
    {
        $currentPath = $this->basePath . ($path ? '/' . $path : '');
        
        // Asegurar que la carpeta base existe
        if (!Storage::disk('public')->exists($currentPath)) {
            Storage::disk('public')->makeDirectory($currentPath);
        }

        // Obtener Directorios (Carpetas)
        $directories = collect(Storage::disk('public')->directories($currentPath))->map(function($dir) {
            return (object) [
                'name' => basename($dir),
                'path' => str_replace($this->basePath . '/', '', $dir),
                'is_file' => false
            ];
        });

        // Obtener Archivos
        $files = collect(Storage::disk('public')->files($currentPath))->map(function($file) {
            return (object) [
                'name' => basename($file),
                'url'  => Storage::url($file),
                'size' => round(Storage::disk('public')->size($file) / 1024, 2) . ' KB',
                'extension' => pathinfo($file, PATHINFO_EXTENSION),
                'is_file' => true
            ];
        });

        $items = $directories->concat($files);
        
        // Calculamos el "Atrás"
        $parentPath = $path ? substr($path, 0, strrpos($path, '/')) : null;

        return view('admin.documentos.index', compact('items', 'path', 'parentPath'));
    }

    public function createFolder(Request $request)
    {
        $request->validate(['folder_name' => 'required|string|max:255']);
        $path = $request->input('current_path'); // Viene de un campo oculto
        $fullPath = $this->basePath . ($path ? '/' . $path : '') . '/' . $request->folder_name;

        Storage::disk('public')->makeDirectory($fullPath);
        return back()->with('success', 'Carpeta creada correctamente.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'archivo' => [
                'required',
                'file',
                'max:30720', // 30MB
                // Lista de extensiones permitidas
                'mimes:jpg,jpeg,png,webp,pdf,xlsx,xls,docx,doc,mp3,wav,aac,ogg,flac'
            ]
        ]);

        $file = $request->file('archivo');
        $originalName = $file->getClientOriginalName();
        
        // Si quieres evitar duplicados puedes usar:
        $name = $originalName;
        $file->storeAs('documentos', $name, 'public');

        $file->storeAs('documentos', $originalName, 'public');

        return back()->with('success', 'Archivo subido.');
    }

    /**
     * Elimina un archivo o una carpeta del disco.
     */
    public function destroy(Request $request)
    {
        // Aceptamos tanto un string (borrado simple) como un array (borrado múltiple)
        $paths = $request->input('item_paths', []);
        
        // Si viene de un formulario antiguo con item_path simple
        if ($request->has('item_path')) {
            $paths[] = $request->input('item_path');
        }

        if (empty($paths)) {
            return back()->with('error', 'No se seleccionó ningún elemento.');
        }

        $count = 0;
        foreach ($paths as $relativePath) {
            $fullPath = $this->basePath . '/' . $relativePath;

            if (Storage::disk('public')->exists($fullPath)) {
                // Comprobamos si es directorio usando la ruta física real
                if (is_dir(storage_path('app/public/' . $fullPath))) {
                    Storage::disk('public')->deleteDirectory($fullPath);
                } else {
                    Storage::disk('public')->delete($fullPath);
                }
                $count++;
            }
        }

        return back()->with('success', "Se han eliminado $count elementos correctamente.");
    }
}