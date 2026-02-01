<?php

declare(strict_types=1);

namespace Src\Identity\Application\UseCases;

use Src\Identity\Application\DTOs\RegisterUserDTO;
use Src\Identity\Domain\Repositories\UserRepository;
use Src\Identity\Domain\User;
use InvalidArgumentException;

/**
 * 💡 Concepto: Caso de Uso (Application Service)
 * Representa una ACCIÓN específica que un usuario puede realizar en el sistema.
 *
 * Reglas:
 * 1. Orquesta, no decide reglas de negocio complejas (eso va en el Dominio).
 * 2. Recibe un DTO, habla con el Repositorio, y devuelve un resultado (o void).
 */
final readonly class RegisterUserUseCase
{
    // Inyección de Dependencias: Le pedimos el Repositorio al construirse.
    // No nos importa si es MySQL o InMemory.
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(RegisterUserDTO $dto): void
    {
        // 1. Validar reglas simples (ej: email duplicado)
        // Nota: Idealmente esto lanzaría una UserAlreadyExistsException de dominio
        if ($this->repository->findByEmail($dto->email)) {
            throw new InvalidArgumentException("User with email {$dto->email} already exists.");
        }

        // 2. Preparar datos
        $hashedPassword = password_hash($dto->password, PASSWORD_BCRYPT);
        $uuid = \Illuminate\Support\Str::uuid()->toString();
        // 3. Crear la Entidad de Dominio
        $user = User::register(
            $uuid,
            $dto->email,
            $hashedPassword
        );

        // 4. Persistir estado
        $this->repository->save($user);
    }
}
