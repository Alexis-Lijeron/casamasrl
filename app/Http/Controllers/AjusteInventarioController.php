<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAjusteInventarioRequest;
use App\Models\AjusteInventario;
use App\Models\ProductoAlmacen;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class AjusteInventarioController extends Controller
{

    public function index()
    {
        $ajustes = AjusteInventario::all();
        return view('dashboard.ajuste_inventarios.index', compact('ajustes'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $almacenes = ProductoAlmacen::with('almacen')
            ->select('almacen_id')
            ->distinct()
            ->get()
            ->pluck('almacen');
        return view('dashboard.ajuste_inventarios.create', compact('proveedores', 'almacenes'));
    }

    public function store(StoreAjusteInventarioRequest $request)
    {
        DB::BeginTransaction();
        try {
            $ajusteInventario = AjusteInventario::create([
                'tipo' => $request->tipo,
                'fecha' => now(),
                'descripcion' => $request->descripcion,
                'usuario_id' => getUsuario()->id,
            ]);

            // Decodificar los productos enviados desde el frontend
            $productos = json_decode($request->productos, true);

            foreach ($productos as $producto) {
                $productoAlmacen = ProductoAlmacen::find($producto['productoAlmacenId']);

                // Validar la cantidad según el tipo de operación
                if ($request->tipo === 'Ingreso') {
                    // Para ingresos, la cantidad debe ser positiva
                    if ($producto['cantidad'] <= 0) {
                        throw new \Exception("La cantidad debe ser positiva para un ingreso.");
                    }
                } elseif ($request->tipo === 'Egreso') {
                    // Para egresos, la cantidad debe ser negativa
                    if ($producto['cantidad'] >= 0) {
                        throw new \Exception("La cantidad debe ser negativa para un egreso.");
                    }

                    // Verificar que haya suficiente stock para el egreso
                    if ($productoAlmacen->stock < abs($producto['cantidad'])) {
                        throw new \Exception(
                            "No hay suficiente stock para el producto '{$productoAlmacen->producto->nombre}' en el almacén '{$productoAlmacen->almacen->nombre}'."
                        );
                    }
                } else {
                    throw new \Exception("Tipo de operación no válido.");
                }

                // Guardar el detalle del ajuste de inventario
                $ajusteInventario->productosAlmacen()->attach($producto['productoAlmacenId'], [
                    'cantidad' => $producto['cantidad']
                ]);

                // Actualizar el stock en la tabla producto_almacen
                $productoAlmacen->update([
                    'stock' => $productoAlmacen->stock + $producto['cantidad'],
                ]);
            }

            DB::commit();
            session()->flash('guardado', 'Ajuste de inventario guardado correctamente.');
            return redirect()->route('ajustes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            // Guardar los productos en la sesión para mantenerlos en la vista
            session()->flash('productos', $request->productos);
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $ajuste = AjusteInventario::find($id);

        if (!$ajuste) {
            session()->flash('error', 'Ajuste de inventario no encontrado.');
            return redirect()->back();
        }

        $proveedores = Proveedor::all();
        $almacenes = ProductoAlmacen::with('almacen')
            ->select('almacen_id')
            ->distinct()
            ->get()
            ->pluck('almacen');

        // Obtener el detalle del ajuste de inventario
        $detalle = $ajuste->productosAlmacen->map(function ($productoAlmacen) {
            return [
                'productoAlmacenId' => $productoAlmacen->id,
                'productoId' => $productoAlmacen->producto->id,
                'productoNombre' => $productoAlmacen->producto->nombre,
                'almacenNombre' => $productoAlmacen->almacen->nombre,
                'cantidad' => $productoAlmacen->pivot->cantidad,
            ];
        });

        return view('dashboard.ajuste_inventarios.edit', compact('ajuste', 'proveedores', 'almacenes', 'detalle'));
    }

    public function update(StoreAjusteInventarioRequest $request, string $id)
    {
        DB::BeginTransaction();
        try {
            // Buscar el ajuste de inventario a actualizar
            $ajusteInventario = AjusteInventario::find($id);

            if (!$ajusteInventario) {
                throw new \Exception('Ajuste de inventario no encontrado.');
            }

            // Actualizar los datos básicos del ajuste de inventario
            $ajusteInventario->update([
                'tipo' => $request->tipo,
                'fecha' => now(),
                'descripcion' => $request->descripcion,
                'usuario_id' => getUsuario()->id,
            ]);

            // Decodificar los productos enviados desde el frontend
            $productos = json_decode($request->productos, true);

            // Eliminar los detalles antiguos del ajuste
            $detallesAntiguos = $ajusteInventario->productosAlmacen()->get();
            foreach ($detallesAntiguos as $detalle) {
                $productoAlmacen = ProductoAlmacen::find($detalle->pivot->producto_almacen_id);
                if ($productoAlmacen) {
                    // Revertir el stock al estado anterior
                    $nuevoStock = $productoAlmacen->stock - $detalle->pivot->cantidad;

                    // Validar que el stock no sea negativo
                    if ($nuevoStock < 0) {
                        throw new \Exception(
                            "El stock no puede ser negativo después de revertir el ajuste para el producto '{$productoAlmacen->producto->nombre}' en el almacén '{$productoAlmacen->almacen->nombre}'."
                        );
                    }

                    // Actualizar el stock
                    $productoAlmacen->update([
                        'stock' => $nuevoStock,
                    ]);
                }
            }
            $ajusteInventario->productosAlmacen()->detach(); // Eliminar los detalles antiguos

            // Procesar los nuevos productos
            foreach ($productos as $producto) {
                $productoAlmacen = ProductoAlmacen::find($producto['productoAlmacenId']);

                // Validar la cantidad según el tipo de operación
                if ($request->tipo === 'Ingreso') {
                    // Para ingresos, la cantidad debe ser positiva
                    if ($producto['cantidad'] <= 0) {
                        throw new \Exception("La cantidad debe ser positiva para un ingreso.");
                    }
                } elseif ($request->tipo === 'Egreso') {
                    // Para egresos, la cantidad debe ser negativa
                    if ($producto['cantidad'] >= 0) {
                        throw new \Exception("La cantidad debe ser negativa para un egreso.");
                    }
                    // Verificar que haya suficiente stock para el egreso
                    if ($productoAlmacen->stock < abs($producto['cantidad'])) {
                        throw new \Exception(
                            "No hay suficiente stock para el producto '{$productoAlmacen->producto->nombre}' en el almacén '{$productoAlmacen->almacen->nombre}'."
                        );
                    }
                } else {
                    throw new \Exception("Tipo de operación no válido.");
                }

                // Guardar el detalle del ajuste de inventario
                $ajusteInventario->productosAlmacen()->attach($producto['productoAlmacenId'], [
                    'cantidad' => $producto['cantidad']
                ]);

                // Actualizar el stock en la tabla producto_almacen
                $productoAlmacen->update([
                    'stock' => $productoAlmacen->stock + $producto['cantidad'],
                ]);
            }

            DB::commit();
            session()->flash('actualizado', 'Ajuste de inventario actualizado correctamente.');
            return redirect()->route('ajustes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            // Guardar los productos en la sesión para mantenerlos en la vista
            session()->flash('productos', $request->productos);
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
    public function destroy(string $id)
    {
        $ajuste = AjusteInventario::find($id);

        if (!$ajuste) {
            session()->flash('error', 'Ajuste de inventario no encontrado.');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            // Eliminar los detalles del ajuste
            foreach ($ajuste->productosAlmacen as $detalle) {
                $productoAlmacen = ProductoAlmacen::find($detalle->id);
                if ($productoAlmacen) {
                    // Revertir el stock al estado anterior
                    $nuevoStock = $productoAlmacen->stock - $detalle->pivot->cantidad;

                    // Validar que el stock no sea negativo
                    if ($nuevoStock < 0) {
                        throw new \Exception(
                            "El stock no puede ser negativo después de revertir el ajuste para el producto '{$productoAlmacen->producto->nombre}' en el almacén '{$productoAlmacen->almacen->nombre}'."
                        );
                    }

                    // Actualizar el stock
                    $productoAlmacen->update([
                        'stock' => $nuevoStock,
                    ]);
                }
            }

            // Eliminar el ajuste de inventario
            $ajuste->delete();

            DB::commit();
            session()->flash('eliminado', 'Ajuste de inventario eliminado correctamente.');
            return redirect()->route('ajustes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}