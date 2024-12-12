<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * El namespace per a les rutes del controlador.
     *
     * @var string|null
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define el camí "home" per a l'aplicació.
     */
    public const HOME = '/home';

    /**
     * Define rutes, agrupaments o comportaments personalitzats.
     */
    public function boot(): void
    {
        parent::boot();

        // Aquí pots definir comportaments personalitzats.
    }

    /**
     * Registra les rutes de l'aplicació.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        // Registra altres rutes si cal.
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
