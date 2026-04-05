<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Obtiene el valor de un setting global.
     * Ejemplo: setting('registro_habilitado')  → true/false
     *          setting('nombre_promo', 'Toni') → valor o default
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}
