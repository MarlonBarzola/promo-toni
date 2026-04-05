<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Codigo;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CodigoController extends Controller
{
    public function index()
{
    $userId = auth()->id();

    $codigos = Codigo::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->paginate(6);

    // 1. Obtener puntos del usuario
    $puntos = DB::table('codigos')
        ->where('estado', 'aprobado')
        ->where('user_id', $userId)
        ->count();

    // 2. Calcular puesto
    $puesto = null;

    if ($puntos > 0) {
        $usuariosConMasPuntos = DB::table('codigos')
            ->select('user_id', DB::raw('COUNT(*) as total'))
            ->where('estado', 'aprobado')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > ?', [$puntos])
            ->count();

        $puesto = $usuariosConMasPuntos + 1;
    }

    return Inertia::render('Cliente/Dashboard', [
        'codigos' => $codigos,
        'ranking' => [
            'usuario' => auth()->user()->usuario,
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
            'codigo_lote.required'   => 'El código de lote es obligatorio.',
            'codigo_lote.regex'      => 'El código de lote debe iniciar con "L" seguido de 5 números (ej. L12345).',
            'codigo_conteo.required' => 'El código de conteo es obligatorio.',
            'codigo_conteo.digits_between' => 'El código de conteo solo debe contener números.',
        ]);

        $codigoUnico = $request->codigo_lote . $request->codigo_conteo;

        if (Codigo::where('codigo_unico', $codigoUnico)->exists()) {
            return back()->withErrors([
                'codigo_lote' => 'Este código ya ha sido registrado anteriormente por otro participante o por ti.',
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
