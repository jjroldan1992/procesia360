<?php

namespace Database\Factories;

use App\Models\Hermano;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hermano>
 */
class HermanoFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente.
     *
     * @var string
     */
    protected $model = Hermano::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 1. Aseguramos que Faker use la localización española para las direcciones
        $faker = \Faker\Factory::create('es_ES');
        
        // 2. Definimos una fecha de alta lógica (ej: entre hace 30 años y hoy)
        $fechaAlta = $faker->dateTimeBetween('-86 years', 'now');
        
        return [
            // Datos personales básicos
            'nombre' => $faker->firstName(),
            'apellido' => $faker->lastName(),
            'dni' => $faker->unique()->dni(),
            'fecha_alta' => $fechaAlta,
            
            // Estado de baja (por defecto ACTIVO)
            'fecha_baja' => null, 
            'fallecido' => false,
            
            // 3. Campos de Domicilio usando Faker español
            'domicilio_calle' => $faker->streetName(),
            'domicilio_numero' => $faker->buildingNumber(),
            'domicilio_cp' => $faker->postcode(),
            'domicilio_poblacion' => $faker->city(),
            'domicilio_provincia' => $faker->state(),
            
            // El numero_hermano se calculará al ejecutar el seeder
            'numero_hermano' => null, 
        ];
    }
}