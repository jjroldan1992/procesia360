<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuota_tarifas', function (Blueprint $table) {
            $table->id();
            $table->year('anio')->unique(); // El año de la tarifa (clave única)
            $table->decimal('importe_ordinario', 8, 2); // Precio base de la cuota
            $table->decimal('importe_extraordinario', 8, 2)->nullable(); // Opcional (si aplica)
            $table->boolean('activa')->default(true); // Para activar o desactivar una tarifa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuota_tarifas');
    }
};