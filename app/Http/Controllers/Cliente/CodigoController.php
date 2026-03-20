<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Codigo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CodigoController extends Controller
{
    public function index()
    {
        $codigos = Codigo::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(1);

        return Inertia::render('Cliente/Dashboard', [
            'codigos' => $codigos
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_unico' => 'required|string|max:20|unique:codigos,codigo_unico',
            'producto' => 'required|string',
            'foto_codigo' => 'required|image|max:2048',
            'foto_empaque' => 'required|image|max:2048',
        ], [
            'codigo_unico.unique' => 'Este código ya ha sido registrado anteriormente por otro participante o por ti.',
            'codigo_unico.required' => 'El código del empaque es obligatorio.',
        ]);

        // Guardar archivos en storage/app/public/promocion
        $pathCodigo = $request->file('foto_codigo')->store('promocion/codigos', 'public');
        $pathEmpaque = $request->file('foto_empaque')->store('promocion/empaques', 'public');

        Codigo::create([
            'user_id' => auth()->id(),
            'codigo_unico' => $request->codigo_unico,
            'producto' => $request->producto,
            'foto_codigo' => $pathCodigo,
            'foto_empaque' => $pathEmpaque,
            'estado' => 'pendiente'
        ]);

        return back()->with('mensaje', '¡Tu código ha sido enviado con éxito y está en revisión!');
    }
}
