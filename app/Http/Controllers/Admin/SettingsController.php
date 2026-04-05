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
                'modo_lotes'          => Setting::get('modo_lotes', 'estricto'),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'key'   => ['required', 'string', 'max:100', Rule::in(['registro_habilitado', 'modo_lotes'])],
            'value' => ['required'],
        ]);

        Setting::set($request->key, $request->input('value'));

        return back()->with('mensaje', 'Configuración guardada.');
    }
}
