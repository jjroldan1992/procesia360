<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('web_settings', function (Blueprint $table) {
            // Añadimos solo los campos que faltan según el error
            if (!Schema::hasColumn('web_settings', 'instagram_url')) {
                $table->string('instagram_url')->nullable();
            }
            if (!Schema::hasColumn('web_settings', 'facebook_url')) {
                $table->string('facebook_url')->nullable();
            }
            if (!Schema::hasColumn('web_settings', 'meta_title')) {
                $table->string('meta_title')->nullable();
            }
            if (!Schema::hasColumn('web_settings', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('web_settings', function (Blueprint $table) {
            $table->dropColumn(['instagram_url', 'facebook_url', 'meta_title', 'meta_description']);
        });
    }
};
