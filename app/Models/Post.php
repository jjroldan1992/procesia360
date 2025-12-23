<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'titulo', 'slug', 'contenido', 'tipo', 'publicado', 'imagen_destacada', 'fecha_publicacion'
    ];

    // Esto crea el slug automáticamente al guardar el título
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->slug = Str::slug($post->titulo);
        });
    }
}