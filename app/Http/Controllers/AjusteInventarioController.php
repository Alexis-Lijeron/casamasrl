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
            // dd($e->getMessage());
            // return back()->with('error', $e->getMessage());
            // return back()->with('error', 'Ocurrió un error al guardar el ajuste de inventario.');
        }
    }
}
