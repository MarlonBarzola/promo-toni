<?php

namespace App\Http\Controllers;

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
}
