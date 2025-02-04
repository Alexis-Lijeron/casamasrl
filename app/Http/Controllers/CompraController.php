<?php

namespace App\Http\Controllers;

use App\Models\NotaCompra;
use App\Http\Requests\StoreCompraRequest;
use App\Http\Requests\UpdateCompraRequest;
use App\Models\AjusteInventario;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\ProductoAlmacen;
use App\Models\Proveedor;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $compras = NotaCompra::all();
        return view('dashboard.compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $almacenes = ProductoAlmacen::with('almacen')
            ->select('almacen_id')
            ->distinct()
            ->get()
            ->pluck('almacen');

        return view('dashboard.compras.create', compact('proveedores', 'almacenes'));
    }

    public function obtenerProductosPorAlmacen($almacen_id)
    {
        $productos = ProductoAlmacen::with('producto')
            ->where('almacen_id', $almacen_id)
            ->get()
            ->map(function ($productoAlmacen) {
                return [
                    'id' => $productoAlmacen->id,
                    'producto_id' => $productoAlmacen->producto->id,
                    'producto_nombre' => $productoAlmacen->producto->nombre,
                    'producto' => $productoAlmacen->producto
                ];
            });

        return response()->json($productos, 200);
    }

    public function store(StoreCompraRequest $request)
    {
        // Iniciar una transacción para asegurar que todo se guarde correctamente
        DB::beginTransaction();
        try {
            // Generar pago
            // $pago = Pago::create([
            //     'monto' => $request->total,
            //     'fecha_pago' => now(),
            //     'estado' => false,
            //     'descripcion' => 'NotaCompra',
            // ]);

            // Crear una nueva compra
            $compra = NotaCompra::create([
                'proveedor_id' => $request->proveedor_id,
                'usuario_id' => getUsuario()->id,
                'monto_total' => $request->total,
                'fecha_compra' => now(),
                'estado' => false
            ]);

            // Recorrer los productos y guardarlos en la tabla detalle_compra
            $productos = json_decode($request->productos, true);

            foreach ($productos as $producto) {
                // Guardar los productos en la tabla de detalle_compra
                $compra->productosAlmacen()->attach($producto['productoAlmacenId'], [
                    'cantidad' => $producto['cantidad'],
                    'precio_compra' => $producto['precioCompra'],
                ]);
            }

            // Commit a la transacción
            DB::commit();
            return redirect()->route('compras.index')->with('guardado', 'Compra creada correctamente');
        } catch (\Exception $e) {
            // Rollback a la transacción
            DB::rollBack();
            return redirect()->route('compras.create')->with('error', 'Ocurrió un error al crear la compra');
        }
    }

    public function show(string $id)
    {
        $compra = NotaCompra::with('productosAlmacen')->find($id);

        if (!$compra) {
            session()->flash('error', 'La compra no existe');
            return redirect()->route('compras.index');
        }

        $productosAsociados = $compra->productosAlmacen->map(function ($productoAlmacen) {
            return [
                'id' => $productoAlmacen->producto_id,
                'nombre' => $productoAlmacen->producto->nombre,
                'cantidad' => $productoAlmacen->pivot->cantidad,
                'precio_compra' => $productoAlmacen->pivot->precio_compra,
                'subtotal' => $productoAlmacen->pivot->cantidad * $productoAlmacen->pivot->precio_compra,
                'productoAlmacenId' => $productoAlmacen->id,
                'almacenNombre' => $productoAlmacen->almacen->nombre,
                'almacenId' => $productoAlmacen->almacen->id,
            ];
        });

        // dd($productosAsociados);
        return view('dashboard.compras.show', compact('productosAsociados', 'compra'));
    }

    public function edit(string $id)
    {
        // $compra = NotaCompra::find($id);
        $compra = NotaCompra::with('productosAlmacen')->find($id);

        if (!$compra) {
            session()->flash('error', 'La compra no existe');
            return redirect()->route('compras.index');
        }

        $productosAsociados = $compra->productosAlmacen->map(function ($productoAlmacen) {
            return [
                'id' => $productoAlmacen->producto_id,
                'nombre' => $productoAlmacen->producto->nombre,
                'cantidad' => $productoAlmacen->pivot->cantidad,
                'precio_compra' => $productoAlmacen->pivot->precio_compra,
                'subtotal' => $productoAlmacen->pivot->cantidad * $productoAlmacen->pivot->precio_compra,
                'productoAlmacenId' => $productoAlmacen->id,
                'almacenNombre' => $productoAlmacen->almacen->nombre,
            ];
        });

        $proveedores = Proveedor::all();
        $almacenes = ProductoAlmacen::with('almacen')
            ->select('almacen_id')
            ->distinct()
            ->get()
            ->pluck('almacen');

        return view('dashboard.compras.edit', compact('productosAsociados', 'compra', 'proveedores', 'almacenes'));
    }

    public function update(UpdateCompraRequest $request, string $id)
    {
        $compra = NotaCompra::find($id);

        if (!$compra) {
            session()->flash('error', 'La compra no existe');
            return redirect()->route('compras.index');
        }

        // Iniciar una transacción para asegurar que todo se guarde correctamente
        DB::beginTransaction();
        try {
            // Actualizar la compra
            $compra->update([
                'proveedor_id' => $request->proveedor_id,
                'usuario_id' => getUsuario()->id,
                'monto_total' => $request->total,
                'fecha_compra' => now(),
            ]);

            // Actualizar el pago
            // $compra->pago->update([
            //     'monto' => $request->total,
            //     'fecha_pago' => now(),
            // ]);

            // Eliminar los productos anteriores de la relación de la compra 
            $compra->productosAlmacen()->detach();

            // Recorrer los productos y guardarlos en la tabla compra_producto
            $productos = json_decode($request->productos, true);
            foreach ($productos as $producto) {
                // Actualizar los productos en la tabla de detalle_compra
                $compra->productosAlmacen()->attach($producto['productoAlmacenId'], [
                    'cantidad' => $producto['cantidad'],
                    'precio_compra' => $producto['precioCompra'],
                ]);
            }

            // Commit a la transacción
            DB::commit();
            return redirect()->route('compras.index')->with('actualizado', 'Compra actualizada correctamente');
        } catch (\Exception $e) {
            // Rollback a la transacción
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('compras.edit', $compra->id)->with('error', 'Ocurrió un error al actualizar la compra');
        }
    }

    public function confirmarCompra(string $id)
    {
        // Iniciar transacción
        DB::beginTransaction();

        try {
            $compra = NotaCompra::find($id);

            if (!$compra) {
                session()->flash('error', 'La compra no existe');
                return redirect()->route('compras.index');
            }

            // Verificar si el pago está confirmado
            // if (!$compra->pago->estado) {
            //     return redirect()->route('compras.index')->with('error', 'El pago de la compra no ha sido confirmado, por favor confirme el pago antes de confirmar la compra');
            // }

            if ($compra->estado) {
                return redirect()->route('compras.index')->with('error', 'La compra ya ha sido confirmada anteriormente');
            }

            // Actualizar el estado de la compra
            $compra->update([
                'estado' => true
            ]);

            // Crear un nuevo registro en la tabla inventario
            $productos = $compra->productosAlmacen;

            $ajusteInventario = AjusteInventario::create([
                'tipo' => 'Ingreso',
                'fecha' => now(),
                'descripcion' => 'Compra de productos',
                'usuario_id' => getUsuario()->id,
            ]);

            foreach ($productos as $producto) {
                // Guardar los productos en la tabla de detalle_ajustes
                $ajusteInventario->productosAlmacen()->attach($producto->id, [
                    'cantidad' => $producto->pivot->cantidad,
                ]);

                // Actualizar el stock en la tabla producto_almacen
                $producto->update([
                    'stock' => $producto->stock + $producto->pivot->cantidad,
                    'fecha_vencimiento' => now()->addMonths(6),
                ]);
            }

            // Commit a la transacción
            DB::commit();

            return redirect()->route('compras.index')->with('confirmado', 'Compra confirmada correctamente');
        } catch (\Exception $e) {
            // Si ocurre un error, hacer rollback a la transacción
            DB::rollBack();
            return redirect()->route('compras.index')->with('error', 'Ocurrió un error al confirmar la compra, por favor intente de nuevo');
        }
    }

    public function destroy(string $id)
    {
        $compra = NotaCompra::find($id);

        if (!$compra) {
            session()->flash('error', 'La compra no existe');
            return redirect()->route('compras.index');
        }

        $compra->delete();
        return redirect()->route('compras.index')->with('eliminado', 'Compra eliminada correctamente');
    }
    public function imprimir($id)
    {
        $compra = NotaCompra::with('productosAlmacen')->find($id);

        if (!$compra) {
            session()->flash('error', 'La compra no existe');
            return redirect()->route('compras.index');
        }

        $productosAsociados = $compra->productosAlmacen->map(function ($productoAlmacen) {
            return [
                'id'              => $productoAlmacen->producto_id,
                'nombre'          => $productoAlmacen->producto->nombre,
                'cantidad'        => $productoAlmacen->pivot->cantidad,
                'precio_compra'   => $productoAlmacen->pivot->precio_compra,
                'subtotal'        => $productoAlmacen->pivot->cantidad * $productoAlmacen->pivot->precio_compra,
                'productoAlmacenId' => $productoAlmacen->id,
                'almacenNombre'   => $productoAlmacen->almacen->nombre,
                'almacenId'       => $productoAlmacen->almacen->id,
            ];
        });

        return view('dashboard.compras.imprimir', compact('compra', 'productosAsociados'));
    }
}
