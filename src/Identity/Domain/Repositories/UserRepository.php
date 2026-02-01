<?php

declare(strict_types=1);

namespace Src\Identity\Domain\Repositories;

use Src\Identity\Domain\User;

/**
 * 💡 Concepto DDD: Repositorio (Repository Interface)
 *
 * El Repositorio es una ilusión. Le hace creer a nuestro Dominio que los objetos
 * están "en memoria" (como una Colección), aunque en realidad se guarden en una Base de Datos.
 *
 * P: ¿Por qué una Interface aquí?
 * R: Para desacoplar. Nuestro Dominio no debe saber QUE base de datos usamos.
 *    Hoy es MySQL, mañana PostgreSQL, o una API externa. Al Dominio no le importa.
 *    Esta interface define EL CONTRATO.
 */
interface UserRepository
{
    public function save(User $user): void;

    public function findByEmail(string $email): ?User;
}
