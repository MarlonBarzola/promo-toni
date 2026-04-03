<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TerminosCondiciones;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TerminosController extends Controller
{
    public function edit(): Response
    {
        $terminos = TerminosCondiciones::first();

        return Inertia::render('Admin/Terminos', [
            'contenido' => $terminos?->contenido ?? '',
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'contenido' => 'required|string',
        ]);

        $terminos = TerminosCondiciones::first();

        if ($terminos) {
            $terminos->update(['contenido' => $request->contenido]);
        } else {
            TerminosCondiciones::create(['contenido' => $request->contenido]);
        }

        return back()->with('mensaje', 'Términos y condiciones actualizados correctamente.');
    }
}
