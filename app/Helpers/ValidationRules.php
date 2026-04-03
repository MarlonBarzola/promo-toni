<?php

namespace App\Helpers;

class ValidationRules
{
    /**
     * Reglas para nombres y apellidos: solo letras (con acentos y ñ), espacios, guiones y puntos.
     */
    public static function name(array $extra = []): array
    {
        return array_merge(['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-\.]+$/u'], $extra);
    }

    /**
     * Reglas para usuario: solo letras sin acento, números y guion bajo.
     */
    public static function username(array $extra = []): array
    {
        return array_merge(['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9_]+$/'], $extra);
    }

    /**
     * Reglas para cédula: exactamente 10 dígitos numéricos.
     */
    public static function cedula(array $extra = []): array
    {
        return array_merge(['required', 'string', 'digits:10', 'regex:/^\d{10}$/'], $extra);
    }

    /**
     * Reglas para teléfono: solo dígitos, máximo 10 caracteres.
     */
    public static function telefono(array $extra = []): array
    {
        return array_merge(['required', 'string', 'max:10', 'regex:/^\d+$/'], $extra);
    }

    /**
     * Reglas para ciudad: solo letras (con acentos y ñ), espacios, guiones y puntos.
     */
    public static function ciudad(array $extra = []): array
    {
        return array_merge(['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-\.]+$/u'], $extra);
    }
}
