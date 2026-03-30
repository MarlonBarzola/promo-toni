<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Codigo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->estado ?? 'pendiente';
        $search = $request->search;

        $codigos = Codigo::with('usuario')
            ->where('estado', $estado)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    // buscar en codigo
                    $q->where('codigo_unico', 'like', "%{$search}%")

                        // buscar en usuario
                        ->orWhereHas('usuario', function ($u) use ($search) {
                            $u->where('nombre', 'like', "%{$search}%")
                                ->orWhere('apellido', 'like', "%{$search}%")
                                ->orWhere('cedula', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('Admin/GestionCodigos', [
            'codigos' => $codigos,
            'filters' => [
                'estado' => $estado,
                'search' => $search
            ],
            'stats' => [
                'pendientes' => Codigo::where('estado', 'pendiente')->count(),
                'aprobados' => Codigo::where('estado', 'aprobado')->count(),
                'rechazados' => Codigo::where('estado', 'rechazado')->count(),
            ]
        ]);
    }

    public function update(Request $request, Codigo $codigo)
    {
        $request->validate([
            'estado'           => 'required|in:aprobado,rechazado',
            'motivo_descarte'  => 'nullable|in:codigo_empaque,foto|required_if:estado,rechazado',
        ]);

        $data = ['estado' => $request->estado];

        if ($request->estado === 'rechazado') {
            $data['motivo_descarte'] = $request->motivo_descarte;
        } else {
            $data['motivo_descarte'] = null;
        }

        $codigo->update($data);

        return back()->with('mensaje', 'El código ha sido ' . $request->estado);
    }

    public function reportes(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;
        $search = $request->search;

        $query = Codigo::with('usuario');

        if ($desde && $hasta) {
            $query->whereBetween('created_at', [$desde, $hasta]);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('codigo_unico', 'like', "%{$search}%")
                    ->orWhereHas('usuario', function ($u) use ($search) {
                        $u->where('nombre', 'like', "%{$search}%")
                            ->orWhere('apellido', 'like', "%{$search}%")
                            ->orWhere('cedula', 'like', "%{$search}%");
                    });
            });
        }

        $codigos = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Reportes', [
            'codigos' => $codigos,
            'filters' => [
                'desde' => $desde,
                'hasta' => $hasta,
                'search' => $search
            ]
        ]);
    }

    public function export(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;
        $search = $request->search;

        $query = Codigo::with('usuario');

        if ($desde && $hasta) {
            $query->whereBetween('created_at', [$desde, $hasta]);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('codigo_unico', 'like', "%{$search}%")
                    ->orWhereHas('usuario', function ($u) use ($search) {
                        $u->where('nombre', 'like', "%{$search}%")
                            ->orWhere('apellido', 'like', "%{$search}%")
                            ->orWhere('cedula', 'like', "%{$search}%");
                    });
            });
        }

        $codigos = $query->get();

        $filename = "reporte_codigos.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($codigos) {
            $file = fopen('php://output', 'w');

            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Nombre',
                'Apellido',
                'Cédula',
                'Código',
                'Estado',
                'Fecha',
                'Foto Código'
            ]);

            foreach ($codigos as $c) {
                fputcsv($file, [
                    $c->usuario->nombre,
                    $c->usuario->apellido,
                    $c->usuario->cedula,
                    $c->codigo_unico,
                    $c->estado,
                    $c->created_at->format('Y-m-d H:i'),
                    url('/storage/' . $c->foto_codigo),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
