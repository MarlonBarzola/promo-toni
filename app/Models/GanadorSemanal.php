<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GanadorSemanal extends Model
{
    protected $table = 'ganadores_semanales';

    protected $fillable = [
        'cedula',
        'usuario',
        'numero_semana',
        'anio',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
