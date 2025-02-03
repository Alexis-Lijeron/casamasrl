<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

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
                    $almacen->productos()->attach($producto['productoId']);
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

    public function show(Almacen $almacen)
    {
        //
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

            // Colocar una fecha de vencimiento para 6 meses después
            $fechaVencimiento = now()->addMonths(6);

            // Si se han seleccionado productos, se guardan en la tabla almacen_producto
            if ($request['productos']) {
                $almacen->productos()->detach();
                $productos = json_decode($request['productos'], true);
                foreach ($productos as $producto) {
                    $almacen->productos()->attach($producto['productoId'], [
                        'fecha_vencimiento' => $fechaVencimiento,
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
}
