<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Codigo;
use App\Models\Lote;
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
            ->leftJoin('lotes', 'lotes.lote', '=', 'codigos.codigo_unico')
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
        $request->validate([
            'codigo_lote'   => ['required', 'string', 'regex:/^L\d{5}$/'],
            'codigo_conteo' => ['required', 'digits_between:1,50'],
            'foto_codigo'   => ['required', 'image', 'max:5120'],
        ], [
            'codigo_lote.required'         => 'El código de lote es obligatorio.',
            'codigo_lote.regex'            => 'El código de lote debe iniciar con "L" seguido de 5 números (ej. L12345).',
            'codigo_conteo.required'       => 'El código de conteo es obligatorio.',
            'codigo_conteo.digits_between' => 'El código de conteo solo debe contener números.',
        ]);

        $codigoUnico = $request->codigo_lote . $request->codigo_conteo;

        // Bloqueo temprano: evitar doble envío del mismo código
        if (Codigo::where('codigo_unico', $codigoUnico)->exists()) {
            return back()->withErrors([
                'codigo_lote' => 'Este código ya ha sido registrado anteriormente.',
            ])->withInput();
        }

        $modo = Setting::get('modo_lotes', 'estricto');

        if ($modo === 'estricto') {
            // Validación atómica con locking para evitar condiciones de carrera
            $resultado = DB::transaction(function () use ($codigoUnico) {
                /** @var \App\Models\Lote|null $lote */
                $lote = Lote::where('lote', $codigoUnico)->lockForUpdate()->first();

                if (!$lote) {
                    return ['estado' => 'invalido'];
                }

                if ($lote->usado) {
                    return ['estado' => 'ya_usado'];
                }

                $lote->update([
                    'usado'   => true,
                    'user_id' => auth()->id(),
                ]);

                // Los puntos se acumularán cuando el admin apruebe el código
                return ['estado' => 'ok'];
            });

            if ($resultado['estado'] === 'invalido') {
                return back()->withErrors([
                    'codigo_lote' => 'El código ingresado no es válido para esta promoción.',
                ])->withInput();
            }

            if ($resultado['estado'] === 'ya_usado') {
                return back()->withErrors([
                    'codigo_lote' => 'Este código ya fue canjeado por otro participante.',
                ])->withInput();
            }
        }
        // Modo libre: no se valida contra lotes, se acepta cualquier código

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

