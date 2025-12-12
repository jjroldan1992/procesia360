<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Actualiza la información de perfil del usuario autenticado.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Reglas de Validación
        $rules = [
            'nombre' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'avatar' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg'],
        ];

        $validatedData = $request->validate($rules);

        // 2. Preparar datos para actualización
        $dataToUpdate = [
            'nombre' => $validatedData['nombre'],
            'apellidos' => $validatedData['apellidos'],
        ];

        // 3. Manejo de la Contraseña (solo si se proporciona)
        if (!empty($validatedData['password'])) {
            $dataToUpdate['password'] = Hash::make($validatedData['password']);
        }

        // 4. Manejo de la Imagen (Avatar)
        if ($request->hasFile('avatar')) {
            
            // A. Si ya existe un avatar antiguo, lo eliminamos para no acumular archivos
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            
            // B. Almacenar el nuevo archivo
            // La imagen se guardará en storage/app/public/avatars y devolverá la ruta relativa
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // C. Guardar la nueva ruta relativa en la base de datos
            $dataToUpdate['avatar_path'] = $path;
        }
        
        // 4. Ejecutar la actualización
        // NOTA: Laravel actualiza automáticamente 'updated_at' al usar el método update() del modelo.
        $user->update($dataToUpdate);

        // 5. Redirección y mensaje
        return redirect()->back()
                         ->with('success', 'Tu perfil ha sido actualizado con éxito. Los cambios se reflejarán en breve.');
    }
}