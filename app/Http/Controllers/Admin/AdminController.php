<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Codigo;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        try {

            $request->validate([
                'estado'           => 'required|in:aprobado,rechazado',
                'motivo_descarte'  => 'nullable|in:codigo_empaque,foto,mejor_foto,caducado|required_if:estado,rechazado',
            ]);

            $estadoAnterior = $codigo->estado;
            $nuevoEstado    = $request->estado;

            $data = ['estado' => $nuevoEstado];

            if ($nuevoEstado === 'rechazado') {
                $data['motivo_descarte'] = $request->motivo_descarte;
            } else {
                $data['motivo_descarte'] = null;
            }

            $codigo->update($data);

            if (
                Setting::get('modo_lotes', 'estricto') === 'estricto'
                && $nuevoEstado !== $estadoAnterior
                && ($nuevoEstado === 'aprobado' || $estadoAnterior === 'aprobado')
                && $codigo->user_id
            ) {
                $total = DB::table('codigos')
                    ->join('lotes', DB::raw('LEFT(codigos.codigo_unico, 6)'), '=', 'lotes.lote')
                    ->where('codigos.user_id', $codigo->user_id)
                    ->where('codigos.estado', 'aprobado')
                    ->sum('lotes.puntos');

                $codigo->usuario()->update([
                    'puntos_acumulados' => (int) $total
                ]);
            }

            return back()->with('mensaje', 'El codigo ha sido ' . $nuevoEstado);
        } catch (\Throwable $e) {

            \Log::error('Error al aprobar codigo', [
                'error' => $e->getMessage()
            ]);

            return back()->with('mensaje', 'El codigo fue procesado, pero hubo un detalle menor.');
        }
    }

    public function reportes(Request $request)
    {
        $desde  = $request->desde;
        $hasta  = $request->hasta;
        $search = $request->search;
        $ciudad = $request->ciudad;

        if ($desde && !$hasta) {
            return back()->with('mensaje', 'Debes ingresar la fecha final.');
        }

        if (!$desde && $hasta) {
            return back()->with('mensaje', 'Debes ingresar la fecha inicial.');
        }

        if ($desde && $hasta && $hasta < $desde) {
            return back()->with('mensaje', 'La fecha final debe ser mayor o igual a la fecha inicial.');
        }

        $query = Codigo::with(['usuario', 'lote']);

        if ($desde && $hasta) {
            $query->whereBetween('created_at', [$desde . ' 00:00:00', $hasta . ' 23:59:59']);
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

        if ($ciudad) {
            $query->whereHas('usuario', function ($u) use ($ciudad) {
                $u->where('ciudad', 'like', "%{$ciudad}%");
            });
        }

        $codigos = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Reportes', [
            'codigos' => $codigos,
            'filters' => [
                'desde'  => $desde,
                'hasta'  => $hasta,
                'search' => $search,
                'ciudad' => $ciudad,
            ]
        ]);
    }

    public function export(Request $request)
    {
        $desde  = $request->desde;
        $hasta  = $request->hasta;
        $search = $request->search;
        $ciudad = $request->ciudad;

        if ($desde && !$hasta) {
            return back()->with('mensaje', 'Debes ingresar la fecha final.');
        }

        if (!$desde && $hasta) {
            return back()->with('mensaje', 'Debes ingresar la fecha inicial.');
        }

        if ($desde && $hasta && $hasta < $desde) {
            return back()->with('mensaje', 'La fecha final debe ser mayor o igual a la fecha inicial.');
        }

        $query = Codigo::with(['usuario', 'lote']);

        if ($desde && $hasta) {
            $query->whereBetween('created_at', [$desde . ' 00:00:00', $hasta . ' 23:59:59']);
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

        if ($ciudad) {
            $query->whereHas('usuario', function ($u) use ($ciudad) {
                $u->where('ciudad', 'like', "%{$ciudad}%");
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
                'Ciudad',
                'Código',
                'Puntos',
                'Estado',
                'Fecha',
                'Foto Código'
            ]);

            foreach ($codigos as $c) {
                fputcsv($file, [
                    $c->usuario->nombre,
                    $c->usuario->apellido,
                    $c->usuario->cedula,
                    $c->usuario->ciudad,
                    $c->codigo_unico,
                    $c->usuario->puntos_acumulados ?? '-',
                    $c->estado,
                    $c->created_at->format('Y-m-d H:i'),
                    url('/storage/' . $c->foto_codigo),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function reporteUsuarios(Request $request)
    {
        $desde  = $request->desde;
        $hasta  = $request->hasta;
        $search = $request->search;
        $ciudad = $request->ciudad;

        if ($desde && !$hasta) {
            return back()->with('mensaje', 'Debes ingresar la fecha final.');
        }

        if (!$desde && $hasta) {
            return back()->with('mensaje', 'Debes ingresar la fecha inicial.');
        }

        if ($desde && $hasta && $hasta < $desde) {
            return back()->with('mensaje', 'La fecha final debe ser mayor o igual a la fecha inicial.');
        }

        $query = User::where('rol', 'cliente');

        if ($desde && $hasta) {
            $query->whereBetween('created_at', [$desde . ' 00:00:00', $hasta . ' 23:59:59']);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('cedula', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($ciudad) {
            $query->where('ciudad', 'like', "%{$ciudad}%");
        }

        $usuarios = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/ReporteUsuarios', [
            'usuarios' => $usuarios,
            'filters'  => [
                'desde'  => $desde,
                'hasta'  => $hasta,
                'search' => $search,
                'ciudad' => $ciudad,
            ],
        ]);
    }

    public function exportUsuarios(Request $request)
    {
        $desde  = $request->desde;
        $hasta  = $request->hasta;
        $search = $request->search;
        $ciudad = $request->ciudad;

        if ($desde && !$hasta) {
            return back()->with('mensaje', 'Debes ingresar la fecha final.');
        }

        if (!$desde && $hasta) {
            return back()->with('mensaje', 'Debes ingresar la fecha inicial.');
        }

        if ($desde && $hasta && $hasta < $desde) {
            return back()->with('mensaje', 'La fecha final debe ser mayor o igual a la fecha inicial.');
        }

        $query = User::where('rol', 'cliente');

        if ($desde && $hasta) {
            $query->whereBetween('created_at', [$desde . ' 00:00:00', $hasta . ' 23:59:59']);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('cedula', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($ciudad) {
            $query->where('ciudad', 'like', "%{$ciudad}%");
        }

        $usuarios = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=reporte_usuarios.csv',
        ];

        $callback = function () use ($usuarios) {
            $file = fopen('php://output', 'w');

            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, ['Nombre', 'Apellido', 'Cédula', 'Email', 'Teléfono', 'Ciudad', 'Puntos', 'Correo Verificado', 'Fecha Registro']);

            foreach ($usuarios as $u) {
                fputcsv($file, [
                    $u->nombre,
                    $u->apellido,
                    $u->cedula,
                    $u->email,
                    $u->telefono,
                    $u->ciudad,
                    $u->puntos_acumulados,
                    $u->email_verified_at ? 'Sí' : 'No',
                    $u->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
