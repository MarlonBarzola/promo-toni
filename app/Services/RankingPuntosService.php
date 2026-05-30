<?php

namespace App\Services;

use App\Models\Codigo;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class RankingPuntosService
{
    public function procesarCambioEstado(Codigo $codigo, string $estadoAnterior, string $nuevoEstado): void
    {
        if (
            Setting::get('modo_lotes', 'estricto') !== 'estricto'
            || (string) Setting::get('ranking_acumula_puntos', '1') !== '1'
            || $nuevoEstado === $estadoAnterior
            || ($nuevoEstado !== 'aprobado' && $estadoAnterior !== 'aprobado')
            || !$codigo->user_id
        ) {
            return;
        }

        $total = DB::table('codigos')
            ->join('lotes', DB::raw('LEFT(codigos.codigo_unico, 6)'), '=', 'lotes.lote')
            ->where('codigos.user_id', $codigo->user_id)
            ->where('codigos.estado', 'aprobado')
            ->sum('lotes.puntos');

        $codigo->usuario()->update([
            'puntos_acumulados' => (int) $total,
        ]);
    }
}
