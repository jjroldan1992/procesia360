<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hermanos', function (Blueprint $table) {
            // numero_hermano actual (puede ser nulo si el sistema no ha corrido el cálculo inicial)
            $table->unsignedSmallInteger('numero_hermano')->nullable()->after('fecha_alta');
        });
    }

    public function down(): void
    {
        Schema::table('hermanos', function (Blueprint $table) {
            $table->dropColumn('numero_hermano');
        });
    }
};