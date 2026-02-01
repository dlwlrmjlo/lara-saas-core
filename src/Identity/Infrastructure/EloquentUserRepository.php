<?php

declare(strict_types=1);

namespace Src\Identity\Infrastructure;

use Src\Identity\Domain\Repositories\UserRepository;
use Src\Identity\Domain\User;
use Src\Identity\Infrastructure\Persistence\Models\UserModel;
use DateTimeImmutable;

/**
 * 💡 Concepto: Adaptador Real (Persistence Adapter)
 * Implementa el contrato del Dominio usando Eloquent.
 *
 * Su trabajo principal es el MAPPING (Traducción):
 * Dominio -> Infraestructura (save)
 * Infraestructura -> Dominio (find)
 */
final class EloquentUserRepository implements UserRepository
{
    public function save(User $user): void
    {
        // 1. Traducir Dominio (User) -> Eloquent (UserModel)
        // Usamos updateOrCreate para cubrir tanto Inserción como Actualización
        UserModel::updateOrCreate(
            ['id' => $user->getUuid()],
            [
                'email' => $user->getEmail(),
                'password' => $user->getPasswordHash(),
                'created_at' => $user->getCreatedAt(),
            ]
        );
    }

    public function findByEmail(string $email): ?User
    {
        // 1. Buscar en BD usando Eloquent
        $eloquentUser = UserModel::where('email', $email)->first();

        if (! $eloquentUser) {
            return null;
        }

        // 2. Traducir Eloquent (UserModel) -> Dominio (User)
        // Reconstruimos la entidad pura.
        return new User(
            uuid: $eloquentUser->id,
            email: $eloquentUser->email,
            passwordHash: $eloquentUser->password,
            createdAt: new DateTimeImmutable($eloquentUser->created_at->toIso8601String()),
        );
    }
}
