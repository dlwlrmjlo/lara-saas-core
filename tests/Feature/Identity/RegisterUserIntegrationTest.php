<?php

declare(strict_types=1);

namespace Tests\Feature\Identity;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Src\Identity\Application\DTOs\RegisterUserDTO;
use Src\Identity\Application\UseCases\RegisterUserUseCase;
use Src\Identity\Infrastructure\EloquentUserRepository;

/**
 * 💡 Concepto: Integration Testing (Prueba de Integración)
 *
 * Aquí probamos "con todo conectado".
 * Usamos la base de datos real (Postgres de prueba) y el Repositorio Eloquent real.
 * Esto nos confirma que nuestras migraciones, modelos y mapping funcionan de verdad.
 */
final class RegisterUserIntegrationTest extends TestCase
{
    // Limpia la BD después de cada test
    use RefreshDatabase;

    public function test_it_persists_user_to_real_database(): void
    {
        // 1. Arrange
        // Usamos la implementación REAL (Eloquent)
        $repository = new EloquentUserRepository();
        $useCase = new RegisterUserUseCase($repository);

        $dto = new RegisterUserDTO(
            email: 'integration@example.com',
            password: 'secret-password'
        );

        // 2. Act
        $useCase->execute($dto);

        // 3. Assert
        // Verificamos directamente en la tabla SQL
        $this->assertDatabaseHas('users', [
            'email' => 'integration@example.com',
        ]);

        // Verificamos que la password NO esté en texto plano
        $this->assertDatabaseMissing('users', [
            'password' => 'secret-password',
        ]);
    }
}
