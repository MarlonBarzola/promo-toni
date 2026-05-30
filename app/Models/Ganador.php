<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ganador extends Model
{
    protected $table = 'ganadores';

    protected $fillable = [
        'posicion',
        'usuario_id',
    ];

    protected function casts(): array
    {
        return [
            'posicion' => 'integer',
            'usuario_id' => 'integer',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
