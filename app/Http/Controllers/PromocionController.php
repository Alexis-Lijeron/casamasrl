<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Events\PromocionCreated;
use App\Events\PromocionUpdated;

class PromocionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promociones = Promocion::with('productos')->get();
        return view('dashboard.promociones.index', compact('promociones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('dashboard.promociones.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descuento' => 'required|numeric|min:0|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id'
        ]);

        $promocion = Promocion::create($request->all());

        foreach($request->productos as $productoId) {
            $producto = Producto::find($productoId);
            $precioConDescuento = $producto->precio_venta * (1 - ($request->descuento / 100));

            $promocion->productos()->attach($productoId, [
                'precio_con_descuento' => $precioConDescuento
            ]);
        }

        event(new PromocionCreated($promocion));

        return redirect()->route('promociones.index')
            ->with('success', 'Promoción creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promocion $promocion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promocion $promocion)
    {
        $productos = Producto::all();
        $productosSeleccionados = $promocion->productos->pluck('id')->toArray();
        return view('dashboard.promociones.edit', compact('promocion', 'productos', 'productosSeleccionados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promocion $promocion)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descuento' => 'required|numeric|min:0|max:100',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after:fecha_inicio',
        'productos' => 'required|array',
        'productos.*' => 'exists:productos,id'
    ]);

    // Guardar productos antiguos para restaurar precios si es necesario
    $oldProductos = $promocion->productos;

    $promocion->update($request->all());

    // Sincronizar nuevos productos con sus precios con descuento
    $productosConDescuento = [];
    foreach($request->productos as $productoId) {
        $producto = Producto::find($productoId);
        $precioConDescuento = $producto->precio_venta * (1 - ($request->descuento / 100));

        $productosConDescuento[$productoId] = [
            'precio_con_descuento' => $precioConDescuento
        ];
    }

    $promocion->productos()->sync($productosConDescuento);

    event(new PromocionUpdated($promocion, $oldProductos));

    return redirect()->route('promociones.index')
        ->with('success', 'Promoción actualizada exitosamente');
}

public function destroy(Promocion $promocion)
{
    // Restaurar precios originales antes de eliminar
    foreach ($promocion->productos as $producto) {
        $producto->precio_actual = $producto->precio_venta;
        $producto->save();
    }

    $promocion->productos()->detach();
    $promocion->delete();

    return redirect()->route('promociones.index')
        ->with('success', 'Promoción eliminada exitosamente');
}
}
