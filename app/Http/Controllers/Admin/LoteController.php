<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class LoteController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'total'       => Lote::count(),
            'usados'      => Lote::where('usado', true)->count(),
            'disponibles' => Lote::where('usado', false)->count(),
        ];

        // Top 10 usuarios por puntos para reportería rápida
        $topUsuarios = DB::table('users')
            ->where('puntos_acumulados', '>', 0)
            ->orderByDesc('puntos_acumulados')
            ->limit(10)
            ->get(['usuario', 'nombre', 'apellido', 'puntos_acumulados']);

        return Inertia::render('Admin/Lotes', [
            'stats'       => $stats,
            'topUsuarios' => $topUsuarios,
        ]);
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:20480'],
        ], [
            'csv.required' => 'El archivo CSV es obligatorio.',
            'csv.mimes'    => 'El archivo debe ser un CSV (.csv o .txt).',
            'csv.max'      => 'El archivo no debe superar los 20 MB.',
        ]);

        $path   = $request->file('csv')->getRealPath();
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return back()->withErrors(['csv' => 'No se pudo leer el archivo.']);
        }

        // Detect and skip header row if present
        $firstLine = fgetcsv($handle);
        $isHeader  = $firstLine
            && count($firstLine) >= 2
            && !is_numeric(trim($firstLine[1]))
            && !preg_match('/^\d+$/', trim($firstLine[1]));

        if (!$isHeader) {
            rewind($handle);
        }

        $batch      = [];
        $insertados = 0;
        $duplicados = 0;
        $errores    = 0;
        $now        = now();

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 2) {
                $errores++;
                continue;
            }

            $lote = strtoupper(trim($row[0]));
            $puntos = intval(trim($row[1]));

            if ($lote === '' || $puntos <= 0) {
                $errores++;
                continue;
            }

            $batch[] = [
                'lote'       => $lote,
                'puntos'     => $puntos,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) >= 1000) {
                $affected   = DB::table('lotes')->insertOrIgnore($batch);
                $insertados += $affected;
                $duplicados += count($batch) - $affected;
                $batch      = [];
            }
        }

        fclose($handle);

        if (!empty($batch)) {
            $affected   = DB::table('lotes')->insertOrIgnore($batch);
            $insertados += $affected;
            $duplicados += count($batch) - $affected;
        }

        $msg = "Importación completada: {$insertados} códigos nuevos";
        if ($duplicados > 0) {
            $msg .= ", {$duplicados} duplicados omitidos";
        }
        if ($errores > 0) {
            $msg .= ", {$errores} filas inválidas";
        }

        return back()->with('mensaje', $msg . '.');
    }
}
