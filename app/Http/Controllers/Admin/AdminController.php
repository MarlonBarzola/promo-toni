<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Codigo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->estado ?? 'pendiente';
        $search = $request->search;

        $codigos = Codigo::with('usuario')
            ->where('estado', $estado)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    // buscar en codigo
                    $q->where('codigo_unico', 'like', "%{$search}%")

                        // buscar en usuario
                        ->orWhereHas('usuario', function ($u) use ($search) {
                            $u->where('nombre', 'like', "%{$search}%")
                                ->orWhere('apellido', 'like', "%{$search}%")
                                ->orWhere('cedula', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('Admin/GestionCodigos', [
            'codigos' => $codigos,
            'filters' => [
                'estado' => $estado,
                'search' => $search
            ],
            'stats' => [
                'pendientes' => Codigo::where('estado', 'pendiente')->count(),
                'aprobados' => Codigo::where('estado', 'aprobado')->count(),
                'rechazados' => Codigo::where('estado', 'rechazado')->count(),
            ]
        ]);
    }

    public function update(Request $request, Codigo $codigo)
    {
        $request->validate([
            'estado' => 'required|in:aprobado,rechazado'
        ]);

        $codigo->update([
            'estado' => $request->estado
        ]);

        return back()->with('mensaje', 'El código ha sido ' . $request->estado);
    }
}
