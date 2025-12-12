<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hermano_numeros_historico', function (Blueprint $table) {
            $table->id();
            
            // FK al hermano afectado
            $table->foreignId('hermano_id')->constrained('hermanos')->onDelete('cascade');
            
            // El número de hermano que tuvo en esa fecha
            $table->unsignedSmallInteger('numero_obtenido');
            
            // La fecha en que ese número se le asignó/actualizó
            $table->date('fecha_asignacion');
            
            // Notas sobre el motivo del cambio (ej: 'Alta inicial', 'Recálculo por baja de Hermano 12')
            $table->string('motivo')->nullable(); 

            $table->timestamps();
            
            // Índice para buscar rápidamente el historial de un hermano
            $table->index(['hermano_id', 'fecha_asignacion']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hermano_numeros_historico');
    }
};