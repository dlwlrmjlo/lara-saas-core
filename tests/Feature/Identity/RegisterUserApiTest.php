<?php

declare(strict_types=1);

namespace Tests\Feature\Identity;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 💡 Concepto: E2E API Testing
 *
 * Probamos desde la "puerta de entrada" (HTTP).
 * Simulamos ser Postman o el Frontend.
 */
final class RegisterUserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_registers_user_via_api(): void
    {
        // 1. Act (Simular petición HTTP)
        $response = $this->postJson('/api/register', [
            'email' => 'api_client@example.com',
            'password' => 'secure-password-123',
        ]);

        // 2. Assert (Verificar Respuesta HTTP)
        $response->assertStatus(201)
            ->assertJson(['message' => 'User registered successfully.']);

        // 3. Assert (Verificar Base de Datos)
        $this->assertDatabaseHas('users', [
            'email' => 'api_client@example.com',
        ]);

        $this->assertDatabaseMissing('users', [
            'password' => 'secure-password-123', // Debe estar hasheada
        ]);
    }

    public function test_it_validates_input(): void
    {
        $response = $this->postJson('/api/register', [
            'email' => '', // Email vacío
            'password' => '123', // Password corta
        ]);

        $response->assertStatus(422) // Unprocessable Entity
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
