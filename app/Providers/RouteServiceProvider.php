<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * El camino a la ruta "home" de la aplicación.
     *
     * Típicamente, los usuarios son redirigidos aquí después de la autenticación.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define el mapeo de rutas de la aplicación.
     */
    public function boot(): void
    {
        // Define las reglas de Rate Limiting (control de velocidad)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Mapeo de archivos de rutas
        $this->routes(function () {
            
            // Rutas de API (opcional)
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Rutas Web (Rutas estándar de la aplicación)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}