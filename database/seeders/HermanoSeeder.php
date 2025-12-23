<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hermano;
use App\Traits\RecalculaNumeroHermano; 
use App\Models\HermanoNumeroHistorico; 
// ¡Ya no necesitamos Illuminate\Support\Facades\DB; aquí!

class HermanoSeeder extends Seeder
{
    use RecalculaNumeroHermano; 

    public function run(): void
    {
        // El control de claves foráneas lo hace DatabaseSeeder.
        
        // 1. TRUNCAR TABLAS RELACIONADAS (limpieza segura)
        //Lo quito, limpiar bases de datos a mano
        
        // 2. Crear 50 hermanos con datos simulados
        Hermano::factory()->count(769)->create();

        // 3. Ejecutar la lógica de recálculo
        $this->recalcularNumeros(); 

        $this->command->info('✅ Censo de Hermanos creado y numerado con éxito.');
    }
}