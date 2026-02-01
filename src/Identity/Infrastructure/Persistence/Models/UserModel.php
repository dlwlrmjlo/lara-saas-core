<?php

declare(strict_types=1);

namespace Src\Identity\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Src\Identity\Domain\User;
use DateTimeImmutable;

/**
 * 💡 Concepto: Modelo de Infraestructura (Eloquent)
 * Este modelo NO es la Entidad de Dominio.
 * Su única responsabilidad es saber cómo hablar con la tabla SQL 'users'.
 *
 * Reglas:
 * 1. Extiende de Eloquent.
 * 2. Configura los cast (fechas, UUIDs).
 * 3. NO contiene lógica de negocio.
 */
final class UserModel extends Model
{
    // Le decimos a Laravel que la tabla es 'users'
    protected $table = 'users';

    // Como usamos UUIDs, no es autoincremental
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'email',
        'password',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
