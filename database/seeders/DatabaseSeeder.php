<?php

namespace Database\Seeders;

use App\Models\Hermano;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Database\Seeders\RoleSeeder::class, // Asumimos que tienes el RoleSeeder
            \Database\Seeders\AdminSeeder::class, // <-- ¡CLAVE! Asegura que el usuario admin se cree
        ]);
        
        Hermano::factory()->count(200)->create();
    }
}
