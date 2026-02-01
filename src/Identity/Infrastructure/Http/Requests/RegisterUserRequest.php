<?php

declare(strict_types=1);

namespace Src\Identity\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            // 'unique:users,email' se podría agregar aquí para validación rápida,
            // pero recuerda que nuestro Caso de Uso YA valida duplicados en el Dominio.
            // Si la agregas aquí, ahorras una llamada al Dominio, lo cual está bien en Infra.
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
