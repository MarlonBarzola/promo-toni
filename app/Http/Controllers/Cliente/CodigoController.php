<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Codigo;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CodigoController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $userId = $user->id;
        $modo   = Setting::get('modo_lotes', 'estricto');

        $codigos = Codigo::where('codigos.user_id', $userId)
            ->leftJoin('lotes', DB::raw('LEFT(codigos.codigo_unico, 6)'), '=', 'lotes.lote')
            ->select('codigos.*', 'lotes.puntos as puntos_lote')
            ->orderBy('codigos.created_at', 'desc')
            ->paginate(6);

        if ($modo === 'estricto') {
            $puntos = (int) $user->puntos_acumulados;
            $puesto = null;
            if ($puntos > 0) {
                $puesto = User::where('puntos_acumulados', '>', $puntos)->count() + 1;
            }
        } else {
            // Modo libre: puntaje = cantidad de códigos del usuario
            $puntos = Codigo::where('user_id', $userId)
                        ->where('estado', 'aprobado')
                        ->count();
            $puesto = null;
            if ($puntos > 0) {
                $puesto = DB::table('codigos')
                    ->select('user_id', DB::raw('COUNT(*) as total'))
                    ->where('estado', 'aprobado')
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) > ?', [$puntos])
                    ->count() + 1;
            }
        }

        return Inertia::render('Cliente/Dashboard', [
            'codigos' => $codigos,
            'ranking' => [
                'usuario' => $user->usuario,
                'puntos'  => $puntos,
                'puesto'  => $puesto,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $modo = Setting::get('modo_lotes', 'estricto');

        $codigoLoteRules = ['required', 'string', 'regex:/^L\d{5}$/'];
        if ($modo === 'estricto') {
            $codigoLoteRules[] = 'exists:lotes,lote';
        }

        $request->validate([
            'codigo_lote'   => $codigoLoteRules,
            'codigo_conteo' => ['required', 'string'],
            'foto_codigo'   => ['required', 'image', 'max:5120'],
        ], [
            'codigo_lote.required' => 'El código de lote es obligatorio.',
            'codigo_lote.regex'    => 'El código de lote debe iniciar con "L" seguido de 5 números (ej. L12345).',
            'codigo_lote.exists'   => 'El código ingresado no es válido para esta promoción.',
            'codigo_conteo.required' => 'El código de conteo es obligatorio.',
        ]);

        $codigoUnico = $request->codigo_lote . $request->codigo_conteo;

        // Evitar doble envío del mismo código completo
        if (Codigo::where('codigo_unico', $codigoUnico)->exists()) {
            return back()->withErrors([
                'codigo_lote' => 'Este código ya ha sido registrado anteriormente.',
            ])->withInput();
        }

        $pathCodigo = $request->file('foto_codigo')->store('promocion/codigos', 'public');

        Codigo::create([
            'user_id'      => auth()->id(),
            'codigo_unico' => $codigoUnico,
            'foto_codigo'  => $pathCodigo,
            'estado'       => 'pendiente',
        ]);

        return back()->with('mensaje', '¡Tu código ha sido enviado con éxito y está en revisión!');
    }
}

