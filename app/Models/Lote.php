<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';

    protected $fillable = [
        'lote',
        'puntos',
        'usado',
        'user_id',
    ];

    protected $casts = [
        'usado'  => 'boolean',
        'puntos' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userLote()
    {
        return $this->hasOne(UserLote::class, 'lote_id');
    }
}
