<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PromocionCreated;
use App\Events\PromocionUpdated;
use Carbon\Carbon;

class ActualizarPreciosPromocion
{
    public function handle($event)
    {
        if ($event instanceof PromocionCreated) {
            $this->actualizarPrecios($event->promocion);
        }

        if ($event instanceof PromocionUpdated) {
            // Restaurar precios anteriores si es necesario
            if ($event->oldProductos) {
                foreach ($event->oldProductos as $producto) {
                    $producto->precio_actual = $producto->precio_venta;
                    $producto->save();
                }
            }
            $this->actualizarPrecios($event->promocion);
        }
    }

    private function actualizarPrecios($promocion)
    {
        $now = Carbon::now();

        // Solo actualizar si la promoción está activa y en el rango de fechas
        if ($promocion->estado === 'activo' &&
            $now->between($promocion->fecha_inicio, $promocion->fecha_fin)) {

            foreach ($promocion->productos as $producto) {
                $precioConDescuento = $producto->precio_venta * (1 - ($promocion->descuento / 100));

                $promocion->productos()->updateExistingPivot(
                    $producto->id,
                    ['precio_con_descuento' => $precioConDescuento]
                );
            }
        }
    }
}
