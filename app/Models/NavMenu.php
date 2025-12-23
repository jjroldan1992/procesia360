<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavMenu extends Model
{
    // Definimos los campos que se pueden guardar desde un formulario
    protected $fillable = [
        'nombre',
        'url',
        'orden',
        'activo'
    ];

    public function children()
    {
        return $this->hasMany(NavMenu::class, 'parent_id')->orderBy('orden');
    }

    public function parent()
    {
        return $this->belongsTo(NavMenu::class, 'parent_id');
    }
}