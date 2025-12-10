<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Desactivar la verificación de FK para poder truncar (limpiar)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        
        // 2. Insertar los roles personalizados
        DB::table('roles')->insert([
            // NOTA: Los IDs deben coincidir con los que usas en el AdminSeeder (ID 1)
            ['id' => 1, 'nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Hermano Mayor', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Secretario', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'Tesorero', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'Miembro de Junta', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nombre' => 'Hermano', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // 3. Reactivar la verificación de FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}