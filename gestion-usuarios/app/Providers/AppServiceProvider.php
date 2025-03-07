<?php

namespace App\Providers;

use App\Core\Application\Interfaces\RepositorioUsuarioInterface;
use App\Core\Application\Interfaces\ServicioUsuarioInterface;
use App\Core\Application\Servicios\UsuarioServicio;
use App\Infrastructure\Persistencia\Eloquent\Repositorios\EloquentUsuarioRepositorio;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // Registrar el repositorio
        $this->app->bind(RepositorioUsuarioInterface::class, EloquentUsuarioRepositorio::class);

        // Registrar el servicio
        $this->app->bind(ServicioUsuarioInterface::class, UsuarioServicio::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // configura el límite de la tasa de solicitudes
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // registra rutas
        $this->routes();
    }

    /**
     * configura las rutas para la aplicación.
     */
    protected function routes(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
