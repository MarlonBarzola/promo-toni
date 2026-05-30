<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Settings', [
            'settings' => [
                'registro_habilitado' => Setting::get('registro_habilitado', false),
                'modo_lotes' => Setting::get('modo_lotes', 'estricto'),
                'ranking_acumula_puntos' => (string) Setting::get('ranking_acumula_puntos', '1'),
                'ranking_template' => (string) Setting::get('ranking_template', '1'),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'key' => ['required', 'string', 'max:100', Rule::in([
                'registro_habilitado',
                'modo_lotes',
                'ranking_acumula_puntos',
                'ranking_template',
            ])],
            'value' => ['required'],
        ]);

        if ($request->key === 'ranking_acumula_puntos') {
            $request->validate([
                'value' => ['in:0,1'],
            ]);
        }

        if ($request->key === 'ranking_template') {
            $request->validate([
                'value' => ['in:1,2,3'],
            ]);
        }

        Setting::set($request->key, $request->input('value'));

        return back()->with('mensaje', 'Configuracion guardada.');
    }
}
