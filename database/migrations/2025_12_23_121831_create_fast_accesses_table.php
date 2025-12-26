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
        Schema::create('fast_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('imagen_path');
            $table->string('alt_text')->nullable(); // Texto alternativo
            $table->string('url'); // Enlace del bloque
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fast_accesses');
    }
};
