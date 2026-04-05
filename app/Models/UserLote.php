<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLote extends Model
{
    protected $table = 'user_lotes';

    protected $fillable = [
        'user_id',
        'lote_id',
        'puntos',
    ];

    protected $casts = [
        'puntos' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}
