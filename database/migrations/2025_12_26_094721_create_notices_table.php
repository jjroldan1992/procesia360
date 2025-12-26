<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('contenido');
            $table->string('tipo'); // 'misa', 'esquela', 'obra', 'campaña', 'general'
            $table->date('fecha_exposicion'); // Cuándo se puso
            $table->date('fecha_finalizacion')->nullable(); // Para que desaparezca solo
            $table->string('adjunto_path')->nullable(); // Por si quieren subir un PDF o foto del aviso real
            $table->boolean('fijado')->default(false); // Para que aparezca el primero con una chincheta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
