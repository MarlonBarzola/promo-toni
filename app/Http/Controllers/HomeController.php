<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\ProductoParticipante;
use App\Models\TerminosCondiciones;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $ranking = User::withCount(['codigos' => function ($query) {
            $query->where('estado', 'aprobado');
        }])
            ->having('codigos_count', '>', 0)
            ->orderBy('codigos_count', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('Home', [
            'ranking' => $ranking
        ]);
    }

    public function terminos()
    {
        $terminos = TerminosCondiciones::first();

        return Inertia::render('Terminos', [
            'contenido' => $terminos?->contenido ?? '',
        ]);
    }

    public function faq()
    {
        return Inertia::render('Faq', [
            'faqs' => Faq::orderBy('orden')->orderBy('id')->get(),
        ]);
    }

    public function productos()
    {
        return Inertia::render('Productos', [
            'productos' => ProductoParticipante::where('activo', true)
                ->orderBy('orden')
                ->orderBy('id')
                ->get(),
        ]);
    }
}
