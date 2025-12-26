<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'red',
        'url',
        'mostrar_en_footer',
        'mostrar_en_contacto'
    ];

    /**
     * Opcional: Si quieres que el modelo siempre devuelva el nombre de la red
     * con la primera letra en mayúscula cuando lo uses en la vista.
     */
    public function getNombreFormatAttribute()
    {
        return ucfirst($this->red);
    }
}