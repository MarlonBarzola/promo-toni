<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\ProductoParticipante;
use App\Models\Setting;
use App\Models\TerminosCondiciones;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $modo = Setting::get('modo_lotes', 'estricto');

        if ($modo === 'estricto') {
            $ranking = User::where('puntos_acumulados', '>', 0)
                ->orderByDesc('puntos_acumulados')
                ->take(5)
                ->get(['id', 'usuario', 'nombre', 'apellido', 'puntos_acumulados']);
        } else {
            $ranking = DB::table('codigos')
                ->join('users', 'users.id', '=', 'codigos.user_id')
                ->select(
                    'users.id',
                    'users.usuario',
                    'users.nombre',
                    'users.apellido',
                    DB::raw('COUNT(codigos.id) as puntos_acumulados')
                )
                ->where('codigos.estado', 'aprobado')
                ->groupBy('users.id', 'users.usuario', 'users.nombre', 'users.apellido')
                ->orderByDesc('puntos_acumulados')
                ->take(5)
                ->get();
        }

        return Inertia::render('Home', [
            'ranking' => $ranking,
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
