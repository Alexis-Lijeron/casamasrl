<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;
use App\Services\PromocionService;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/productos/{producto}/precio-actual', function (Producto $producto) {
    $promocionService = app(PromocionService::class);
    $precioActual = $promocionService->obtenerPrecioConDescuento($producto);

    return response()->json([
        'precio' => $precioActual,
        'tiene_promocion' => $precioActual !== $producto->precio_venta
    ]);
});
