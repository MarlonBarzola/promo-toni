<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    use HasFactory;

    protected $table = 'codigos';
    protected $appends = ['fecha_formateada'];

    protected $fillable = [
        'user_id',
        'codigo_unico',
        'foto_codigo',
        'estado',
        'motivo_descarte',
    ];

    public function getFechaFormateadaAttribute()
    {
        return $this->created_at?->format('Y-m-d H:i');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // lotes.lote = codigos.codigo_unico (foreign key on lotes side is 'lote')
    public function lote()
    {
        return $this->hasOne(Lote::class, 'lote', 'codigo_unico');
    }
}
