<?php
// app/Services/PromocionService.php
namespace App\Services;
use App\Models\Producto;
use App\Models\Promocion;

class PromocionService
{
    public function obtenerPrecioConDescuento($producto)
    {
        $promocionActiva = $producto->promociones()
            ->where('fecha_inicio', '<=', now())
            ->where('fecha_fin', '>=', now())
            ->where('estado', 'activo')
            ->first();

        if ($promocionActiva) {
            return $promocionActiva->pivot->precio_con_descuento;
        }

        return $producto->precio_venta;
    }

    public function aplicarDescuentoAProductos($promocion, $productos)
    {
        $productosConDescuento = [];
        foreach ($productos as $productoId) {
            $producto = Producto::find($productoId);
            $precioConDescuento = $producto->precio_venta * (1 - ($promocion->descuento / 100));
            $productosConDescuento[$productoId] = [
                'precio_con_descuento' => round($precioConDescuento, 2)
            ];
        }
        return $productosConDescuento;
    }
}
