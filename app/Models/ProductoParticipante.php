<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoParticipante extends Model
{
    protected $table = 'productos_participantes';

    protected $fillable = ['nombre', 'orden', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
