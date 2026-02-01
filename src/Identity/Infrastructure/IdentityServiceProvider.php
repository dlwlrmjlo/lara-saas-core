<?php

declare(strict_types=1);

namespace Src\Identity\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Src\Identity\Domain\Repositories\UserRepository;
use Src\Identity\Infrastructure\EloquentUserRepository;

/**
 * 💡 Concepto: Wiring (Cableado)
 *
 * Aquí "conectamos" los cables de la arquitectura.
 * Le decimos a Laravel:
 * "Cuando alguien pida la Interfaz UserRepository... dale el EloquentUserRepository".
 *
 * Si mañana cambiamos a MongoUserRepository, SOlO cambiamos esta línea.
 */
class IdentityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class
        );
    }
}
