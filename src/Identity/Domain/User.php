<?php

declare(strict_types=1);

namespace Src\Identity\Domain;

use DateTimeImmutable;

/**
 * 💡 Concepto DDD: Entidad (Entity)
 * Una Entidad es un objeto que tiene una "Identidad" única que perdura en el tiempo,
 * aunque sus atributos cambien. (Ej: Tú eres la misma persona aunque te cambies de ropa o de nombre).
 *
 * Reglas de Arquitectura:
 * 1. Final: No queremos herencia, preferimos composición.
 * 2. Private Properties: Nadie toca el estado interno directamente.
 * 3. Pure PHP: Cero dependencias de Laravel aquí.
 */
final class User
{
    /**
     * @param string $uuid ID único universal
     * @param string $email Correo electrónico validado
     * @param string $passwordHash Contraseña ya hasheada (seguridad)
     * @param DateTimeImmutable $createdAt Fecha de creación inmutable
     */
    public function __construct(
        private string $uuid,
        private string $email,
        private string $passwordHash,
        private DateTimeImmutable $createdAt,
    ) {}

    /**
     * 🏭 Factory Method (Constructor Semántico)
     * En lugar de usar `new User(...)` por todos lados, usamos un método estático
     * que describe QUÉ está pasando. Aquí estamos "Registrando" un usuario.
     */
    public static function register(string $uuid, string $email, string $passwordHash): self
    {
        return new self(
            $uuid,
            $email,
            $passwordHash,
            new DateTimeImmutable()
        );
    }

    // --- Getters (Solo lectura para el exterior) ---

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    // --- Comportamiento de Dominio (Business Logic) ---

    // Ejemplo de lógica futura: cambiar contraseña, verificar email, etc.
}
