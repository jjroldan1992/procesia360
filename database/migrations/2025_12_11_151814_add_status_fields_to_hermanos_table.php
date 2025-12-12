<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hermanos', function (Blueprint $table) {
            // Fecha en que el hermano dejó de ser activo (baja o fallecimiento)
            $table->date('fecha_baja')->nullable()->after('numero_hermano');
            
            // Flag para indicar si la baja fue por fallecimiento (default false)
            $table->boolean('fallecido')->default(false)->after('fecha_baja');
        });
    }

    public function down(): void
    {
        Schema::table('hermanos', function (Blueprint $table) {
            $table->dropColumn(['fecha_baja', 'fallecido']);
        });
    }
};