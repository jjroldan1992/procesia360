<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hermanos', function (Blueprint $table) {
            // Campos de Domicilio
            $table->string('domicilio_calle')->nullable()->after('fallecido');
            $table->string('domicilio_numero')->nullable(); // Número y bloque/piso
            $table->string('domicilio_cp', 10)->nullable(); // Código Postal
            $table->string('domicilio_poblacion')->nullable();
            $table->string('domicilio_provincia')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('hermanos', function (Blueprint $table) {
            $table->dropColumn([
                'domicilio_calle',
                'domicilio_numero',
                'domicilio_cp',
                'domicilio_poblacion',
                'domicilio_provincia'
            ]);
        });
    }
};