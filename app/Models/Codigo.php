<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    use HasFactory;

    protected $table = 'codigos';

    protected $fillable = [
        'user_id',
        'codigo_unico',
        'producto',
        'foto_codigo',
        'foto_empaque',
        'estado' // pendiente, aprobado, rechazado
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}