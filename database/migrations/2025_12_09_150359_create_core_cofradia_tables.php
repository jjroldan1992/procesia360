<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // TABLA 1: ROLES
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' (BIGINT, auto-increment, PK)
            $table->string('nombre', 50)->unique(); // Crea 'nombre' (VARCHAR(50), único)
            $table->timestamps(); // Crea 'created_at' y 'updated_at' automáticamente
        });

        // TABLA 2: USUARIOS
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            
            // Clave Foránea a la tabla 'roles'
            // 'constrained' asume que la FK se llama 'rol_id' y hace referencia a 'roles'.
            $table->foreignId('rol_id')->constrained('roles');
            
            $table->string('email')->unique();
            $table->string('password'); // Laravel necesita esta columna para la autenticación
            
            // Columnas necesarias para el sistema de Laravel (opcionales)
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            
            $table->timestamps();
        });

        // TABLA 3: HERMANOS (CENSO)
        Schema::create('hermanos', function (Blueprint $table) {
            $table->id();

            // Clave Foránea a la tabla 'usuarios' (Para enlazar datos personales con la cuenta de login)
            $table->foreignId('usuario_id')->nullable()->constrained(); // Puede ser nulo si el Hermano aún no tiene cuenta de login

            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 20)->unique(); // DNI debe ser único
            $table->date('fecha_alta'); // Columna para la fecha en que se hizo hermano
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la tabla de hermanos primero, porque tiene la FK a 'usuarios'
        Schema::dropIfExists('hermanos');
        
        // Eliminar la tabla de usuarios
        Schema::dropIfExists('usuarios');
        
        // Eliminar la tabla de roles al final
        Schema::dropIfExists('roles');
    }
};
