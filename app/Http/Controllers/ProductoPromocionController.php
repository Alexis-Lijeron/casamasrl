<?php

namespace App\Http\Controllers;

use App\Models\ProductoPromocion;
use Illuminate\Http\Request;

class ProductoPromocionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductoPromocion $productoPromocion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductoPromocion $productoPromocion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductoPromocion $productoPromocion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductoPromocion $productoPromocion)
    {
        //
    }
    public function updatePrecioConDescuento($productoId, $promocionId)
    {
        $productoPromocion = ProductoPromocion::where('producto_id', $productoId)
            ->where('promocion_id', $promocionId)
            ->first();

        if ($productoPromocion) {
            $producto = $productoPromocion->producto;
            $promocion = $productoPromocion->promocion;

            $precioConDescuento = $producto->precio_venta * (1 - ($promocion->descuento / 100));

            $productoPromocion->precio_con_descuento = $precioConDescuento;
            $productoPromocion->save();
        }
    }
}
