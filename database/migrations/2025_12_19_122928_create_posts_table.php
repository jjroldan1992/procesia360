<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->enum('tipo', ['noticia', 'pagina', 'comunicado', 'evento'])->default('noticia');
            $table->longText('contenido');
            $table->string('imagen_destacada')->nullable();
            $table->boolean('publicado')->default(false);
            $table->timestamp('fecha_publicacion')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('posts'); }
};