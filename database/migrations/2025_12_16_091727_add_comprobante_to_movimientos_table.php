<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            //
        });
    }

    public function up(): void {
        Schema::table('movimientos', function (Blueprint $table) {
            // Guardamos la ruta del archivo (PDF o Imagen)
            $table->string('comprobante_path')->nullable()->after('documento_referencia');
        });
    }
};
