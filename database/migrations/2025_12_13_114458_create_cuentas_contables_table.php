<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // TABLA: CUENTAS CONTABLES (Bancos o Efectivo)
        Schema::create('cuentas_contables', function (Blueprint $table) {
            $table->id();
            
            // Datos de la cuenta
            $table->string('nombre', 100); // Nombre descriptivo (ej: Cuenta Principal BBVA, Caja 2025)
            $table->enum('tipo', ['Banco', 'Efectivo'])->default('Banco'); // Tipo de cuenta
            $table->string('iban', 34)->nullable(); // IBAN (solo para Bancos)
            $table->string('entidad', 100)->nullable(); // Entidad Bancaria
            
            // Saldos
            $table->decimal('saldo_inicial', 10, 2)->default(0); // Saldo con el que se abre la cuenta
            $table->decimal('saldo_actual', 10, 2)->default(0); // Saldo que se actualizará con movimientos
            
            $table->boolean('activa')->default(true); // Indica si la cuenta está en uso
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuentas_contables');
    }
};