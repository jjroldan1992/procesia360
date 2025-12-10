<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hermano extends Model
{
    use HasFactory;

    // 1. Configuración de la tabla
    // Laravel asume 'hermanos' (plural), que es correcto en español.
    protected $table = 'hermanos'; 

    // 2. Atributos "Fillable" (Permitidos para asignación masiva)
    // Estos son los campos que creaste en la migración (excluyendo 'id', 'created_at', 'updated_at').
    protected $fillable = [
        'usuario_id',
        'nombre',
        'apellido',
        'dni',
        'fecha_alta', // Campo de fecha que necesitarás para la antigüedad
    ];

    // 3. Casts (Casteo de datos)
    // Especificamos que 'fecha_alta' debe ser manejado como un objeto de fecha/tiempo.
    protected $casts = [
        'fecha_alta' => 'date', 
    ];

    // 4. Relación: Opcional con Usuario
    /**
     * Obtiene la cuenta de acceso (Usuario) asociada a este Hermano (opcional).
     */
    public function usuario()
    {
        // Es una relación uno a uno: un Hermano puede tener un Usuario.
        // La clave foránea es 'usuario_id' en la tabla 'hermanos'.
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}