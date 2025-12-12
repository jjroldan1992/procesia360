<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // <-- AÑADIR ESTE IMPORT

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DESHABILITAR LAS RESTRICCIONES DE CLAVE FORÁNEA
        Schema::disableForeignKeyConstraints();

        $this->call([
            AdminSeeder::class,
            RoleSeeder::class,
            HermanoSeeder::class, // <-- Tu seeder principal
        ]);
        
        // 2. HABILITAR LAS RESTRICCIONES DE CLAVE FORÁNEA
        Schema::enableForeignKeyConstraints();
    }
}