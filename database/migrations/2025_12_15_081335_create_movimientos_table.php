<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            
            // Relación con la cuenta
            // Usamos constrained() para crear la clave foránea a 'cuentas_contables'
            $table->foreignId('cuenta_contable_id')->constrained('cuentas_contables')->onDelete('restrict');
            
            // Datos del movimiento
            $table->enum('tipo', ['Ingreso', 'Gasto']);
            $table->string('concepto', 255);
            $table->date('fecha'); // Fecha en la que ocurrió el movimiento
            $table->decimal('cantidad', 10, 2); // Cantidad (siempre positiva, el signo lo da el campo 'tipo')
            $table->string('documento_referencia', 50)->nullable(); // Ej: Número de factura, recibo
            
            // Futuro: Para enlazar categorías (ej: Cuotas, Donativos, Luz, Agua)
            // $table->foreignId('categoria_id')->nullable()->constrained()->onDelete('set null'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};