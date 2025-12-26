<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactConfig extends Model
{
    protected $fillable = [
        'google_maps_script', 'email', 'direccion', 'codigo_postal', 
        'municipio', 'provincia', 'telefono_llamadas', 
        'telefono_whatsapp', 'url_lista_difusion'
    ];
}
