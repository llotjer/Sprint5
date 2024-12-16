<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Els esdeveniments i listeners de l'aplicació.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Exemple:
        // 'App\Events\SomeEvent' => [
        //     'App\Listeners\SomeListener',
        // ],
    ];

    /**
     * Registra serveis relacionats amb esdeveniments.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determina si s'han de descobrir els listeners automàticament.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
