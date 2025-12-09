<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // La tabla por defecto es 'roles', que es correcta
    // protected $table = 'roles'; 

    // 1. Relación: Un Rol tiene muchos Usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
}
