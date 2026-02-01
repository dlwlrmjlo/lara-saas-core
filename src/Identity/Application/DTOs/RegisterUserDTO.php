<?php

declare(strict_types=1);

namespace Src\Identity\Application\DTOs;

/**
 * 💡 Concepto: DTO (Data Transfer Object)
 * Una caja boba. Solo transporta datos.
 *
 * ¿Por qué usarlo?
 * Para no pasar arrays asociativos `['name' => 'Joe']` por toda la app,
 * lo cual es propenso a errores. Con un DTO, sabemos exactamente qué datos tenemos.
 *
 * `readonly`: Una vez creado, nadie puede modificar sus datos.
 */
final readonly class RegisterUserDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
