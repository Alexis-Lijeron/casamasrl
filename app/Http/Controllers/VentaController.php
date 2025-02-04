<?php

namespace App\Http\Controllers;

use App\Models\NotaVenta;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\AjusteInventario;
use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\ProductoAlmacen;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = NotaVenta::all();
        return view('dashboard.ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('dashboard.ventas.create', compact('clientes', 'productos'));
    }

    public function store(StoreVentaRequest $request)
    {

        DB::beginTransaction();
        try {
            // Decodificar el JSON de productos
            $productos = json_decode($request->productos, true);

            // Crear la venta
            $venta = NotaVenta::create([
                'cliente_id' => $request->cliente_id,
                'monto_total' => $request->total,
                'fecha_venta' => now(),
                'descuento' => 0,
                'usuario_id' => getUsuario()->id
            ]);

            $totalVenta = 0;

            // Procesar cada producto
            foreach ($productos as $detalle) {
                $productoId = $detalle['productoId'];
                $cantidadSolicitada = $detalle['cantidad'];
                $subtotal = 0;

                // Obtener los lotes de producto_almacen asociados a compras, ordenados por fecha de compra (FIFO)
                $productoAlmacen = ProductoAlmacen::where('producto_id', $productoId)
                    ->where('stock', '>', 0)
                    ->join('detalle_compras', 'producto_almacen.id', '=', 'detalle_compras.producto_almacen_id')
                    ->join('nota_compras', 'detalle_compras.compra_id', '=', 'nota_compras.id')
                    ->orderBy('nota_compras.fecha_compra', 'asc') // Ordenar por fecha de compra
                    ->select('producto_almacen.*') // Seleccionar los datos de producto_almacen
                    ->get();

                if ($productoAlmacen->isEmpty()) {
                    session()->flash('error', 'El producto no tiene stock suficiente');
                    return redirect()->back();
                }

                $cantidadRestante = $cantidadSolicitada;

                // Aplicar lógica FIFO para consumir stock
                foreach ($productoAlmacen as $lote) {
                    if ($cantidadRestante <= 0) break;

                    // Determinar cuánto tomar del lote actual
                    $cantidadTomar = min($cantidadRestante, $lote->stock);

                    // Reducir el stock del lote
                    $lote->stock -= $cantidadTomar;
                    $lote->save();

                    // Calcular subtotal para este lote
                    $subtotal += $cantidadTomar * $detalle['precioUnitario'];

                    // Reducir la cantidad restante
                    $cantidadRestante -= $cantidadTomar;

                    // Relacionar venta con producto_almacen
                    $venta->productosAlmacen()->attach($lote->id, [
                        'cantidad' => $cantidadTomar,
                        'precio_venta' => $detalle['precioUnitario'],
                    ]);
                }

                if ($cantidadRestante > 0) {
                    session()->flash('error', 'No hay suficiente stock para completar la venta');
                    return redirect()->back();
                }

                // Sumar al total de la venta
                $totalVenta += $subtotal;
            }

            // Actualizar el total de la venta
            $venta->monto_total = $totalVenta;
            $venta->save();

            // Ajustar el inventario
            // $this->ajusteInventario($venta);

            // Generar el pago
            Pago::create([
                'monto' => $totalVenta,
                'fecha_pago' => now(),
                'estado' => false,
                'descripcion' => 'Pago de venta',
                'venta_id' => $venta->id,
            ]);

            DB::commit();
            session()->flash('guardado', 'Venta procesada correctamente');
            return redirect()->route('ventas.index');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la venta');
            return redirect()->route('ventas.index');
        }
    }

    private function ajusteInventario(NotaVenta $venta)
    {
        // Ajustar el inventario
        $ajuste = AjusteInventario::create([
            'usuario_id' => getUsuario()->id,
            'tipo' => 'Egreso',
            'fecha' => now(),
            'descripcion' => 'Venta de productos',
        ]);

        // Obtener los productos de la venta
        $productos = $venta->productosAlmacen;

        // Procesar cada producto
        foreach ($productos as $producto) {
            // Crear el detalle de ajuste
            $ajuste->productosAlmacen()->attach($producto->id, [
                'cantidad' => $producto->pivot->cantidad,
            ]);
        }
    }

    public function show(string $id)
    {
        // Cargar la venta con las relaciones necesarias: cliente, usuario y productos asociados (con su producto)
        $venta = NotaVenta::with(['cliente', 'usuario', 'productosAlmacen.producto'])->find($id);

        if (!$venta) {
            session()->flash('error', 'La venta no existe');
            return redirect()->route('ventas.index');
        }

        // Mapear los productos asociados para enviar a la vista
        $productosAsociados = $venta->productosAlmacen->map(function ($productoAlmacen) {
            return [
                'id'           => $productoAlmacen->producto_id,
                'nombre'       => $productoAlmacen->producto->nombre,
                'cantidad'     => $productoAlmacen->pivot->cantidad,
                'precio_venta' => $productoAlmacen->pivot->precio_venta,
                'subtotal'     => $productoAlmacen->pivot->cantidad * $productoAlmacen->pivot->precio_venta,
                // Si en tu modelo de ventas también manejas almacenes, puedes incluirlos:
                // 'almacenNombre' => $productoAlmacen->almacen->nombre,
                // 'almacenId'     => $productoAlmacen->almacen->id,
            ];
        });

        return view('dashboard.ventas.show', compact('venta', 'productosAsociados'));
    }


    public function edit(string $id)
    {
        $venta = NotaVenta::find($id);
        $clientes = Cliente::all();
        $productos = Producto::all();
        $productosAsociados = $venta->productosAlmacen->map(function ($productoAlmacen) {
            return [
                'id' => $productoAlmacen->producto_id,
                'nombre' => $productoAlmacen->producto->nombre,
                'cantidad' => $productoAlmacen->pivot->cantidad,
                'precio_venta' => $productoAlmacen->pivot->precio_venta,
                'subtotal' => $productoAlmacen->pivot->cantidad * $productoAlmacen->pivot->precio_venta,
                'productoAlmacenId' => $productoAlmacen->id,
            ];
        });
        return view('dashboard.ventas.edit', compact('venta', 'clientes', 'productos', 'productosAsociados'));
    }

    public function update(UpdateVentaRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            // Obtener la venta existente
            $venta = NotaVenta::find($id);

            if (!$venta) {
                session()->flash('error', 'La venta no existe');
                return redirect()->route('ventas.index');
            }

            $productos = json_decode($request->productos, true);

            // Obtener los productos actuales de la venta
            $productosActuales = $venta->productosAlmacen()->get();

            // Eliminar los productos asociados a esta venta y devolver el stock
            foreach ($productosActuales as $producto) {
                // Obtener el stock actual del producto_almacen
                $productoAlmacen = ProductoAlmacen::find($producto->id);

                // Aumentar el stock del producto
                $productoAlmacen->stock += $producto->pivot->cantidad;
                $productoAlmacen->save();
            }

            // Eliminar los productos asociados a esta venta
            $venta->productosAlmacen()->detach();
            $totalVenta = 0;

            // Procesar cada producto
            foreach ($productos as $detalle) {
                $productoId = $detalle['productoId'];
                $cantidadSolicitada = $detalle['cantidad'];
                $subtotal = 0;

                // Obtener los lotes de producto_almacen asociados a compras, ordenados por fecha de compra (FIFO)
                $productoAlmacen = ProductoAlmacen::where('producto_id', $productoId)
                    ->where('stock', '>', 0)
                    ->join('detalle_compras', 'producto_almacen.id', '=', 'detalle_compras.producto_almacen_id')
                    ->join('nota_compras', 'detalle_compras.compra_id', '=', 'nota_compras.id')
                    ->orderBy('nota_compras.fecha_compra', 'asc') // Ordenar por fecha de compra
                    ->select('producto_almacen.*') // Seleccionar los datos de producto_almacen
                    ->get();

                if ($productoAlmacen->isEmpty()) {
                    // Si no hay stock, mostrar mensaje de error
                    session()->flash('error', 'El producto no tiene stock suficiente');
                    return redirect()->back();
                }

                $cantidadRestante = $cantidadSolicitada;

                // Aplicar lógica FIFO para consumir stock
                foreach ($productoAlmacen as $lote) {
                    if ($cantidadRestante <= 0) break;

                    // Determinar cuánto tomar del lote actual
                    $cantidadTomar = min($cantidadRestante, $lote->stock);

                    // Reducir el stock del lote
                    $lote->stock -= $cantidadTomar;
                    $lote->save();

                    // Calcular subtotal para este lote
                    $subtotal += $cantidadTomar * $detalle['precioUnitario'];

                    // Reducir la cantidad restante
                    $cantidadRestante -= $cantidadTomar;

                    // Relacionar venta con producto_almacen
                    $venta->productosAlmacen()->attach($lote->id, [
                        'cantidad' => $cantidadTomar,
                        'precio_venta' => $detalle['precioUnitario'],
                    ]);
                }

                if ($cantidadRestante > 0) {
                    // Si no se pudo completar la venta con el stock disponible, mostrar error
                    session()->flash('error', 'No hay suficiente stock para completar la venta');
                    return redirect()->back();
                }

                // Sumar al total de la venta
                $totalVenta += $subtotal;
            }

            // Actualizar los datos de la venta
            $venta->cliente_id = $request->cliente_id;
            $venta->usuario_id = getUsuario()->id;
            $venta->descuento = 0;
            $venta->fecha_venta = now();
            $venta->monto_total = $totalVenta;
            $venta->save();

            // Ajustar el inventario
            // $this->ajusteInventario($venta);

            // Actualizar el pago
            $pago = Pago::where('venta_id', $venta->id)->first();
            $pago->monto = $totalVenta;
            $pago->save();

            DB::commit();
            session()->flash('actualizado', 'Venta actualizada correctamente');
            return redirect()->route('ventas.index');
        } catch (\Exception $e) {
            // Si ocurre algún error, revertir la transacción
            DB::rollBack();
            session()->flash('error', 'Ocurrió un error al actualizar la venta');
            return redirect()->route('ventas.index');
        }
    }

    public function destroy(string $id)
    {
        $venta = NotaVenta::find($id);

        if (!$venta) {
            session()->flash('error', 'La venta no existe');
            return redirect()->route('ventas.index');
        }

        // Devolver el stock de los productos
        foreach ($venta->productosAlmacen as $producto) {
            $productoAlmacen = ProductoAlmacen::find($producto->id);
            $productoAlmacen->stock += $producto->pivot->cantidad;
            $productoAlmacen->save();
        }

        $venta->delete();
        session()->flash('eliminado', 'Venta eliminada correctamente');
        return redirect()->route('ventas.index');
    }
}
