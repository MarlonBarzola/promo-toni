<?php

namespace App\Exports;

use App\Models\Codigo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CodigosExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $desde;
    protected $hasta;
    protected $search;

    public function __construct($desde, $hasta, $search)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Codigo::with('usuario');

        if ($this->desde && $this->hasta) {
            $query->whereBetween('created_at', [$this->desde, $this->hasta]);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('codigo_unico', 'like', "%{$this->search}%")
                    ->orWhereHas('usuario', function ($u) {
                        $u->where('nombre', 'like', "%{$this->search}%")
                            ->orWhere('apellido', 'like', "%{$this->search}%")
                            ->orWhere('cedula', 'like', "%{$this->search}%");
                    });
            });
        }

        $baseUrl = config('app.url'); // 👈 clave

        return $query->get()->map(function ($c) use ($baseUrl) {
            return [
                $c->usuario->nombre,
                $c->usuario->apellido,
                $c->usuario->cedula,
                $c->codigo_unico,
                $c->producto,
                $c->estado,
                $c->created_at->format('Y-m-d H:i'),

                $baseUrl . '/storage/' . $c->foto_codigo,
                $baseUrl . '/storage/' . $c->foto_empaque,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Cédula',
            'Código',
            'Producto',
            'Estado',
            'Fecha',
            'Foto Código (URL)',
            'Foto Empaque (URL)',
        ];
    }
}
