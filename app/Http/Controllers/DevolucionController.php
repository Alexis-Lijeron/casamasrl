<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use App\Http\Requests\StoreDevolucionRequest;
use App\Http\Requests\UpdateDevolucionRequest;
use App\Models\AjusteInventario;
use App\Models\NotaCompra;
use App\Models\ProductoAlmacen;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    public function index()
    {
        $devoluciones = Devolucion::all();
        return view('dashboard.devoluciones.index', compact('devoluciones'));
    }

    public function create()
    {
        //
    }

    public function store(StoreDevolucionRequest $request, string $compraId)
    {
        DB::beginTransaction();
        try {
            $compra = NotaCompra::find($compraId);

            if (!$compra) {
                session()->flash('error', 'La compra no existe.');
                return redirect()->route('compras.index');
            }

            // Obtener el producto_almacen
            $productoAlmacen = ProductoAlmacen::find($request->producto_almacen_id);

            if (!$productoAlmacen) {
                session()->flash('error', 'El producto no existe.');
                return redirect()->route('compras.index');
            }

            // Crear la devolución
            $devolucion = Devolucion::create([
                'compra_id' => $compra->id,
                'usuario_id' => getUsuario()->id,
                'motivo' => $request->motivo,
                'fecha_devolucion' => now(),
                'monto_total' => $request->monto_total,
            ]);

            // Asociar el producto_almacen a la devolución
            $devolucion->productosAlmacen()->attach($productoAlmacen->id, [
                'cantidad' => $request->cantidad,
            ]);
            
            // Actualizar la cantidad en la compra
            $cantidadCompra = $compra->productosAlmacen()->where('producto_almacen_id', $productoAlmacen->id)->first()->pivot->cantidad;
            $compra->productosAlmacen()->updateExistingPivot($productoAlmacen->id, [
                'cantidad' => $cantidadCompra - (int) $request->cantidad,
            ]);

            // Actualizar la cantidad en el producto_almacen
            $productoAlmacen->stock -= (int) $request->cantidad;
            $productoAlmacen->save();

            // Actualizar el monto total de la compra
            $compra->monto_total -= $request->monto_total;
            $compra->save();
            
            // Ajustar el inventario
            $this->ajusteInventario($devolucion);
            
            DB::commit();
            session()->flash('guardado', 'La devolución se ha registrado correctamente.');
            return redirect()->route('compras.show', $compra->id);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            session()->flash('error', 'Ocurrió un error al registrar la devolución.');
            return redirect()->route('compras.show', $compra->id);
        }
    }
    
    private function ajusteInventario(Devolucion $devolucion)
    {
        // Ajustar el inventario
        $ajuste = AjusteInventario::create([
            'usuario_id' => getUsuario()->id,
            'tipo' => 'Egreso',
            'fecha' => now(),
            'descripcion' => 'Devolución de compra',
        ]);

        // Obtener los productos de la devolucion
        $productos = $devolucion->productosAlmacen;

        // Procesar cada producto
        foreach ($productos as $producto) {
            // Crear el detalle de ajuste
            $ajuste->productosAlmacen()->attach($producto->id, [
                'cantidad' => $producto->pivot->cantidad,
            ]);
        }
    }

    public function show(Devolucion $devolucion)
    {
        //
    }

    public function edit(Devolucion $devolucion)
    {
        //
    }

    public function update(UpdateDevolucionRequest $request, Devolucion $devolucion)
    {
        //
    }

    public function destroy(Devolucion $devolucion)
    {
        //
    }
}
