<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductoParticipante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductoParticipanteController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Productos', [
            'productos' => ProductoParticipante::orderBy('orden')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos_participantes,nombre',
        ]);

        $orden = ProductoParticipante::max('orden') + 1;

        ProductoParticipante::create([
            'nombre' => strtoupper(trim($request->nombre)),
            'orden'  => $orden,
            'activo' => true,
        ]);

        return back()->with('mensaje', 'Producto agregado correctamente.');
    }

    public function update(Request $request, ProductoParticipante $producto): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos_participantes,nombre,' . $producto->id,
            'activo' => 'boolean',
        ]);

        $producto->update([
            'nombre' => strtoupper(trim($request->nombre)),
            'activo' => $request->boolean('activo'),
        ]);

        return back()->with('mensaje', 'Producto actualizado correctamente.');
    }

    public function destroy(ProductoParticipante $producto): RedirectResponse
    {
        $producto->delete();

        return back()->with('mensaje', 'Producto eliminado correctamente.');
    }
}
