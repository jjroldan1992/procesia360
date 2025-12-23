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
    Schema::create('web_settings', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_hermandad')->nullable();
        $table->string('logo_path')->nullable();
        $table->integer('tema_id')->default(1); // 1, 2 o 3
        $table->string('color_primario')->default('#4A1010');
        $table->string('color_secundario')->default('#D4AF37');
        $table->json('modulos_config')->nullable(); // Para activar/desactivar secciones
        $table->string('meta_title')->nullable();
        $table->text('meta_description')->nullable();
        $table->string('instagram_url')->nullable();
        $table->string('facebook_url')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
