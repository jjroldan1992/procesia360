<?php

namespace Database\Factories;

use App\Models\Hermano;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon; // Clase para manejar fechas fácilmente

class HermanoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hermano::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Genera una fecha de alta aleatoria entre hace 15 años y 1 día.
        $fecha_alta = $this->faker->dateTimeBetween('-15 years', 'yesterday');

        return [
            // No asignamos usuario_id intencionalmente, ya que es opcional.
            
            // Campos obligatorios:
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'dni' => $this->faker->unique()->numerify('########A'), // Genera un DNI ficticio
            'fecha_alta' => $fecha_alta,
            
            // Si tuvieras más campos, los añadirías aquí.
        ];
    }
}