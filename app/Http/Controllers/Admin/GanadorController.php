<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ganador;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class GanadorController extends Controller
{
    public function index(): Response
    {
        $ganadores = Ganador::with('usuario:id,usuario,cedula,nombre,apellido')
            ->get()
            ->keyBy('posicion');

        $primero = $ganadores->get(1)?->usuario;
        $segundo = $ganadores->get(2)?->usuario;

        return Inertia::render('Admin/Ganadores', [
            'ganadores' => [
                'primero' => $ganadores->get(1)?->usuario_id,
                'segundo' => $ganadores->get(2)?->usuario_id,
                'primero_usuario' => $primero ? [
                    'id' => $primero->id,
                    'usuario' => $primero->usuario,
                    'cedula' => $primero->cedula,
                    'nombre' => $primero->nombre,
                    'apellido' => $primero->apellido,
                ] : null,
                'segundo_usuario' => $segundo ? [
                    'id' => $segundo->id,
                    'usuario' => $segundo->usuario,
                    'cedula' => $segundo->cedula,
                    'nombre' => $segundo->nombre,
                    'apellido' => $segundo->apellido,
                ] : null,
            ],
        ]);
    }

    public function buscarUsuarios(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 3) {
            return response()->json([]);
        }

        $like = '%' . $q . '%';

        $usuarios = User::query()
            ->where('rol', 'cliente')
            ->where(function ($query) use ($like) {
                $query->where('usuario', 'like', $like)
                    ->orWhere('cedula', 'like', $like)
                    ->orWhere('nombre', 'like', $like)
                    ->orWhere('apellido', 'like', $like);
            })
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->limit(15)
            ->get(['id', 'usuario', 'cedula', 'nombre', 'apellido']);

        return response()->json($usuarios);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'primer_lugar' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('rol', 'cliente')),
                'different:segundo_lugar',
            ],
            'segundo_lugar' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('rol', 'cliente')),
                'different:primer_lugar',
            ],
        ], [
            'primer_lugar.different' => 'El usuario seleccionado ya fue asignado a otra posicion.',
            'segundo_lugar.different' => 'El usuario seleccionado ya fue asignado a otra posicion.',
        ]);

        DB::transaction(function () use ($data) {
            Ganador::query()->delete();

            Ganador::create([
                'posicion' => 1,
                'usuario_id' => $data['primer_lugar'],
            ]);

            Ganador::create([
                'posicion' => 2,
                'usuario_id' => $data['segundo_lugar'],
            ]);
        });

        return back()->with('mensaje', 'Ganadores guardados correctamente.');
    }
}
