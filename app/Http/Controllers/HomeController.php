<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // Obtenemos los 5 mejores (puedes ajustar el límite)
        $ranking = User::withCount(['codigos' => function ($query) {
            $query->where('estado', 'aprobado');
        }])
            ->orderBy('codigos_count', 'desc')
            ->take(5)
            ->get();
            
        return Inertia::render('Home', [
            'ranking' => $ranking
        ]);
    }
}
