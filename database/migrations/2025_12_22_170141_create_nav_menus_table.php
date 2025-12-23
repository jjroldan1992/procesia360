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
    Schema::create('nav_menus', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // Texto que se ve en el menú
        $table->string('url');    // Destino (slug o URL completa)
        $table->integer('orden')->default(0); // Para que el usuario decida qué va antes
        $table->boolean('activo')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nav_menus');
    }
};
