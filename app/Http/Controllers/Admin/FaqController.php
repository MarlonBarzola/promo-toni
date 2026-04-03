<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Faq', [
            'faqs' => Faq::orderBy('orden')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pregunta' => 'required|string|max:500',
            'respuesta' => 'required|string',
        ]);

        $orden = Faq::max('orden') + 1;

        Faq::create([
            'pregunta' => $request->pregunta,
            'respuesta' => $request->respuesta,
            'orden'     => $orden,
        ]);

        return back()->with('mensaje', 'Pregunta agregada correctamente.');
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $request->validate([
            'pregunta' => 'required|string|max:500',
            'respuesta' => 'required|string',
        ]);

        $faq->update([
            'pregunta' => $request->pregunta,
            'respuesta' => $request->respuesta,
        ]);

        return back()->with('mensaje', 'Pregunta actualizada correctamente.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return back()->with('mensaje', 'Pregunta eliminada correctamente.');
    }
}
