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
        Schema::create('contact_configs', function (Blueprint $table) {
            $table->id();
            $table->text('google_maps_script')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('municipio')->nullable();
            $table->string('provincia')->nullable();
            $table->string('telefono_llamadas')->nullable();
            $table->string('telefono_whatsapp')->nullable();
            $table->string('url_lista_difusion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_configs');
    }
};
