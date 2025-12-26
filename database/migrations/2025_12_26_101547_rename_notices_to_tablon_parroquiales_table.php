<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('notices', 'tablon_parroquial');
    }

    public function down(): void
    {
        Schema::rename('tablon_parroquial', 'notices');
    }
};