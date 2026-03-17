<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Codigo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // Traemos los códigos pendientes con los datos del usuario
        $codigos = Codigo::with('usuario')
                         ->where('estado', 'pendiente')
                         ->orderBy('created_at', 'asc')
                         ->get();

        return Inertia::render('Admin/GestionCodigos', [
            'codigos' => $codigos
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