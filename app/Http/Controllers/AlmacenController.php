<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\DetalleCompra;
use App\Models\Marca;
use App\Models\NotaCompra;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoAlmacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::all();
        return view('dashboard.almacenes.index', compact('almacenes'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('dashboard.almacenes.create', compact('productos'));
    }

    public function store(StoreAlmacenRequest $request)
    {
        DB::beginTransaction();
        try {
            $almacen = Almacen::create([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
            ]);

            if (!$almacen) {
                session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
                return redirect()->back();
            }

            // Si se han seleccionado productos, se guardan en la tabla almacen_producto
            if ($request['productos']) {
                $productos = json_decode($request['productos'], true);
                foreach ($productos as $producto) {
                    $almacen->productos()->attach($producto['productoId'], [
                        'fecha_vencimiento' => $producto['fechaVencimiento'],
                    ]);
                }
            }


            DB::commit();
            session()->flash('guardado', '¡Guardado! El almacén ha sido guardado exitosamente.');
            return redirect()->route('almacenes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
    }

    public function show(string $id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            session()->flash('error', 'Almacén no encontrado.');
            return redirect()->back();
        }

        $productos = $almacen->productos->map(function ($producto) {

            $compra = DetalleCompra::where('producto_almacen_id', $producto->pivot->id)->first();

            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'categoria' => $producto->categoria->nombre,
                'marca' => $producto->marca->nombre,
                'precio_venta' => $producto->precio_venta,
                'precio_compra' => $compra ? $compra->precio_compra : 0,
                'imagen' => $producto->url_imagen,
                'stock' => $producto->pivot->stock,
                'fecha_vencimiento' => $producto->pivot->fecha_vencimiento,
            ];
        });

        $categorias = Categoria::all();
        $marcas = Marca::all();

        return view('dashboard.almacenes.show', compact('almacen', 'productos', 'categorias', 'marcas'));
    }


    public function edit(string $id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            session()->flash('error', 'Almacén no encontrado.');
            return redirect()->back();
        }

        $productos = Producto::all();
        return view('dashboard.almacenes.edit', compact('almacen', 'productos'));
    }

    public function update(UpdateAlmacenRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $almacen = Almacen::find($id);

            if (!$almacen) {
                session()->flash('error', 'Almacén no encontrado.');
                return redirect()->back();
            }

            $almacen->update([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
            ]);

            if ($request->filled('productos')) {
                $productos = json_decode($request['productos'], true);

                $almacen->productos()->detach();

                foreach ($productos as $producto) {
                    $almacen->productos()->attach($producto['productoId'], [
                        'fecha_vencimiento' => $producto['fechaVencimiento'],
                    ]);
                }
            }

            DB::commit();
            session()->flash('actualizado', '¡Actualizado! El almacén ha sido actualizado exitosamente.');
            return redirect()->route('almacenes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            session()->flash('error', 'Almacén no encontrado.');
            return redirect()->back();
        }

        $almacen->delete();
        session()->flash('eliminado', '¡Eliminado! El almacén ha sido eliminado exitosamente.');
        return redirect()->route('almacenes.index');
    }

    // public function obtenerStock(string $productoId, string $almacenId) {
    //     $almacen = Almacen::find($almacenId);
    //     $producto = Producto::find($productoId);

    //     if (!$almacen || !$producto) {
    //         return response()->json([
    //             'error' => 'Ha ocurrido un error. Por favor, intenta nuevamente.',
    //         ], 400);
    //     }

    //     $stock = $almacen->productos()->where('producto_id', $productoId)->first()->pivot->stock;

    //     return response()->json($stock, 200);
    // }
    public function vencimientos(Request $request)
    {
        $query = ProductoAlmacen::query();

        // Filtros según el tipo seleccionado
        if ($request->filter_type == 'vencidos') {
            $query->where('fecha_vencimiento', '<', now());
        } elseif ($request->filter_type == 'proximos') {
            $query->whereBetween('fecha_vencimiento', [now(), now()->addMonth()]);
        } elseif ($request->filter_type == 'rango' && $request->start_date && $request->end_date) {
            $query->whereBetween('fecha_vencimiento', [$request->start_date, $request->end_date]);
        }

        $productos = $query->with('producto', 'almacen')->get();

        return view('dashboard.almacenes.vencimientos', compact('productos'));
    }
}
