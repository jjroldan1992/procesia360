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
        Schema::table('usuarios', function (Blueprint $table) {
            // Añadir el nombre (requerido)
            $table->string('nombre')->after('rol_id');
            // Añadir los apellidos (opcional, para flexibilidad)
            $table->string('apellidos')->nullable()->after('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Eliminar las columnas si hacemos rollback
            $table->dropColumn(['nombre', 'apellidos']);
        });
    }
};
