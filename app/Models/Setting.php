<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = ['key', 'value'];

    /**
     * Obtiene el valor de un setting por clave.
     * Usa cache de 60 minutos para evitar consultas repetidas.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $value = Cache::remember("setting.{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->value('value');
        });

        if ($value === null) {
            return $default;
        }

        // Convertir strings booleanos a bool
        if ($value === 'true')  return true;
        if ($value === 'false') return false;

        return $value;
    }

    /**
     * Guarda o actualiza un setting e invalida su cache.
     */
    public static function set(string $key, mixed $value): void
    {
        $stored = is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;

        static::updateOrCreate(['key' => $key], ['value' => $stored]);

        Cache::forget("setting.{$key}");
    }
}
