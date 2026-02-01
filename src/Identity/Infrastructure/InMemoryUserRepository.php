<?php

declare(strict_types=1);

namespace Src\Identity\Infrastructure;

use Src\Identity\Domain\Repositories\UserRepository;
use Src\Identity\Domain\User;

/**
 * 💡 Concepto: Mock / In-Memory Adapter
 * Esta clase simula ser una base de datos.
 *
 * Como implementa `UserRepository`, nuestro Caso de Uso puede usarla SIN SABER
 * que en realidad solo está guardando arrays en memoria RAM.
 *
 * Esto nos permite testear la lógica de negocio rapidísimo, sin tocar MySQL.
 */
final class InMemoryUserRepository implements UserRepository
{
    /** @var array<string, User> */
    private array $users = [];

    public function save(User $user): void
    {
        // Simulamos un "INSERT" o "UPDATE"
        // Indexamos por email para facilitar la búsqueda
        $this->users[$user->getEmail()] = $user;
    }

    public function findByEmail(string $email): ?User
    {
        // Simulamos un "SELECT * FROM users WHERE email = ..."
        return $this->users[$email] ?? null;
    }
}
