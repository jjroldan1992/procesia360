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
        Schema::table('web_settings', function (Blueprint $table) {
            // Eliminamos la columna antigua
            $table->dropColumn('tema_id');
        });
    }

    public function down(): void
    {
        Schema::table('web_settings', function (Blueprint $table) {
            // Por si necesitas dar marcha atrás, la recreamos
            $table->unsignedBigInteger('tema_id')->nullable();
        });
    }
};
