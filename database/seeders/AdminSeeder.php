<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ----------------------------------------------------
        // 1. DESACTIVAR LA VERIFICACIÓN DE CLAVES FORÁNEAS (SOLUCIÓN AL ERROR)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // ----------------------------------------------------

        // Limpiamos la tabla de usuarios sin violar la restricción
        DB::table('usuarios')->truncate(); 

        // Insertamos el usuario administrador principal
        DB::table('usuarios')->insert([
            'rol_id' => 1, // ID 1: Administrador
            'email' => 'admin@procesia360.es', 
            'password' => Hash::make('password'), 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ----------------------------------------------------
        // 2. REACTIVAR LA VERIFICACIÓN DE CLAVES FORÁNEAS
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // ----------------------------------------------------
    }
}