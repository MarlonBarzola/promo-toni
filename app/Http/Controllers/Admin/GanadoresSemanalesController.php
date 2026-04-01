<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GanadorSemanal;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GanadoresSemanalesController extends Controller
{
    public function public()
    {
        $ganadores = GanadorSemanal::where('activo', true)
            ->orderBy('created_at', 'asc')
            ->take(7)
            ->get()
            ->map(fn($g) => [
                'cedula'  => $this->maskCedula($g->cedula),
                'usuario' => $g->usuario,
            ]);

        return Inertia::render('Ganadores', [
            'ganadores' => $ganadores,
        ]);
    }

    public function index()
    {
        $semanaActual = now()->isoWeek();
        $anioActual   = now()->year;

        $ganadores = GanadorSemanal::where('activo', true)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($g) => [
                'id'      => $g->id,
                'cedula'  => $g->cedula,
                'usuario' => $g->usuario,
            ]);

        return Inertia::render('Admin/GanadoresSemanales', [
            'ganadores'     => $ganadores,
            'semanaActual'  => $semanaActual,
            'anioActual'    => $anioActual,
            'totalActivos'  => $ganadores->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'archivo' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ], [
            'archivo.required' => 'Debes seleccionar un archivo CSV.',
            'archivo.mimes'    => 'El archivo debe ser un CSV válido.',
        ]);

        $semanaActual = now()->isoWeek();
        $anioActual   = now()->year;

        // Deshabilitar registros de semanas anteriores
        GanadorSemanal::where(function ($q) use ($semanaActual, $anioActual) {
            $q->where('numero_semana', '!=', $semanaActual)
              ->orWhere('anio', '!=', $anioActual);
        })->update(['activo' => false]);

        $handle = fopen($request->file('archivo')->getPathname(), 'r');

        $insertados = 0;
        $primeraFila = true;

        while (($fila = fgetcsv($handle)) !== false) {
            $cedula = isset($fila[0]) ? trim($fila[0]) : null;

            // Eliminar BOM UTF-8 que añaden Excel/Notepad al inicio del archivo
            if ($primeraFila) {
                $cedula = ltrim($cedula, "\xEF\xBB\xBF");
                $primeraFila = false;
            }

            if (!$cedula || !ctype_digit($cedula)) {
                continue;
            }

            // Saltar si la cédula ya fue cargada en la semana actual
            $yaExiste = GanadorSemanal::where('cedula', $cedula)
                ->where('numero_semana', $semanaActual)
                ->where('anio', $anioActual)
                ->exists();

            if ($yaExiste) {
                continue;
            }

            $usuario = User::where('cedula', $cedula)->first();

            GanadorSemanal::create([
                'cedula'        => $cedula,
                'usuario'       => $usuario?->usuario,
                'numero_semana' => $semanaActual,
                'anio'          => $anioActual,
                'activo'        => true,
            ]);

            $insertados++;
        }

        fclose($handle);

        return back()->with('mensaje', "Se cargaron {$insertados} ganador(es) para la semana {$semanaActual}.");
    }

    private function maskCedula(string $cedula): string
    {
        $len = strlen($cedula);
        if ($len <= 5) {
            return $cedula;
        }
        return substr($cedula, 0, 4) . str_repeat('X', $len - 5) . substr($cedula, -1);
    }
}
