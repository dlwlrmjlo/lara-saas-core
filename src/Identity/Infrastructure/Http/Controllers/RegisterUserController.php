<?php

declare(strict_types=1);

namespace Src\Identity\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Src\Identity\Infrastructure\Http\Requests\RegisterUserRequest;
use Src\Identity\Application\DTOs\RegisterUserDTO;
use Src\Identity\Application\UseCases\RegisterUserUseCase;

/**
 * 💡 Concepto: Primary Adapter (Controlador HTTP)
 *
 * Este es el "Volante" del coche.
 * Su única función es traducir HTTP (Request) -> Cajas del Negocio (DTO).
 * Y luego traducir Respuestas del Negocio -> HTTP (JSON).
 */
final class RegisterUserController extends Controller
{
    public function __invoke(RegisterUserRequest $request, RegisterUserUseCase $useCase): JsonResponse
    {
        // 1. Obtener datos validados (FormRequest)
        $data = $request->validated();

        // 2. Empaquetar en DTO (Transporte Seguro)
        $dto = new RegisterUserDTO(
            email: $data['email'],
            password: $data['password']
        );

        // 3. Ejecutar el Caso de Uso (Lógica Pura)
        // Nota: Laravel inyecta automáticamente el UseCase por nosotros.
        $useCase->execute($dto);

        // 4. Responder al Mundo (Presentación)
        return response()->json([
            'message' => 'User registered successfully.',
        ], 201);
    }
}
