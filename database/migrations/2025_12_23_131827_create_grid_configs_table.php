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
        Schema::create('grid_configs', function (Blueprint $table) {
            $table->id();
            // Guardaremos los tipos permitidos como un array JSON
            $table->json('tipos_permitidos')->nullable(); 
            $table->integer('cantidad_mostrar')->default(6);
            $table->string('titulo_seccion')->default('Actualidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grid_configs');
    }
};
