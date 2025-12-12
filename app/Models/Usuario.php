<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importante para la autenticación
use Illuminate\Notifications\Notifiable; // Incluido por defecto, útil para futuras notificaciones

// Importamos el modelo Role
use App\Models\Role; 

// Nota: Utilizamos 'Usuario' en español para reflejar mejor tu lógica de negocio, 
// pero hereda las funcionalidades de 'User'.
class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Configuración de la tabla
    // Indica a Laravel que este modelo usa la tabla 'usuarios' (en plural)
    protected $table = 'usuarios'; 

    // 2. Atributos "Fillable" (Permitidos para asignación masiva)
    // Permite asignar estos campos al crear un nuevo registro.
    protected $fillable = [
        'rol_id',
        'nombre',
        'apellidos',
        'email',
        'password',
        'remember_token',
        'avatar_path',
    ];

    // 3. Atributos "Hidden" (Ocultos en salidas de Array/JSON)
    // Es CRÍTICO ocultar el password.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 4. Relación: Un Usuario pertenece a un Rol (FK: rol_id)
    /**
     * Obtiene el rol al que pertenece el usuario.
     */
    public function rol()
    {
        // Asume que la clave foránea es rol_id en la tabla 'usuarios'
        return $this->belongsTo(Role::class); 
    }

    // 5. Relación: Un Usuario (con acceso) puede estar vinculado a un Hermano (en el Censo)
    /**
     * Obtiene la ficha del Hermano asociada a esta cuenta de acceso.
     */
    public function hermano()
    {
        // Asume que la clave foránea es 'usuario_id' en la tabla 'hermanos'.
        // Es una relación uno a uno.
        return $this->hasOne(Hermano::class, 'usuario_id');
    }
    
    // 6. Métodos de Acceso (Helpers para verificar el rol)
    
    /**
     * Verifica si el usuario tiene el rol de Administrador.
     */
    public function isAdmin()
    {
        // Asume que el ID 1 es el Administrador según tu tabla de roles.
        return $this->rol_id === 1;
    }

    /**
     * Verifica si el usuario pertenece a la Junta Directiva (Roles 1 a 5).
     */
    public function isJunta()
    {
        // Si el ID del rol es 1 (Admin) a 5 (Miembro de Junta)
        return $this->rol_id >= 1 && $this->rol_id <= 5;
    }

    /**
     * Accesor para obtener las iniciales del nombre y apellido.
     */
    public function getInitialsAttribute(): string
    {
        $nombre = $this->nombre ?? '';
        $apellido = $this->apellidos ?? '';
        
        // Retorna las iniciales en mayúsculas (ej: "JR")
        return strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
    }

    /**
     * Accesor para obtener la URL del avatar. (SE SIMPLIFICA)
     * Ahora solo devuelve la URL si existe el path.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->avatar_path) {
            return asset('storage/' . $this->avatar_path);
        }
        return null;
    }
}