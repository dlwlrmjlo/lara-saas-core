<?php

declare(strict_types=1);

namespace Tests\Unit\Identity;

use PHPUnit\Framework\TestCase;
use Src\Identity\Application\DTOs\RegisterUserDTO;
use Src\Identity\Application\UseCases\RegisterUserUseCase;
use Src\Identity\Infrastructure\InMemoryUserRepository;

/**
 * 💡 Concepto: Unit Testing Puro
 *
 * Al usar Inyección de Dependencias y Repositorios en Memoria,
 * podemos probar nuestra lógica de negocio MINUTOS antes de tener una base de datos real.
 * Estos tests corren en milisegundos.
 */
final class RegisterUserTest extends TestCase
{
    public function test_it_can_register_a_new_user(): void
    {
        // 1. Arrange (Preparar)
        // Usamos la implementación "falsa" (In-Memory) del repositorio.
        $repository = new InMemoryUserRepository();
        $useCase = new RegisterUserUseCase($repository);
        
        $dto = new RegisterUserDTO(
            email: 'test@example.com',
            password: 'super-secret-password'
        );

        // 2. Act (Actuar)
        $useCase->execute($dto);

        // 3. Assert (Verificar)
        // Le preguntamos al repositorio "falso" si guardó al usuario.
        $savedUser = $repository->findByEmail('test@example.com');

        $this->assertNotNull($savedUser, 'El usuario debería haber sido guardado en el repositorio.');
        $this->assertEquals('test@example.com', $savedUser->getEmail());
        $this->assertNotEquals('super-secret-password', $savedUser->getPasswordHash(), 'La contraseña debería estar hasheada.');
    }


    public function test_it_throws_exception_if_email_already_exists(): void
    {
        // 1. Arrange
        $repository = new InMemoryUserRepository();
        $useCase = new RegisterUserUseCase($repository);
        
        // Registramos al primero
        $useCase->execute(new RegisterUserDTO('duplicate@example.com', '123456'));

        // 2. Assert (Esperamos excepción)
        $this->expectException(\InvalidArgumentException::class);
        // 3. Act (Intentamos registrar al segundo con el mismo email)
        $useCase->execute(new RegisterUserDTO('duplicate@example.com', 'new-password'));
    }
}
