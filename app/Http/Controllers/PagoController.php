<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use App\Models\MetodoPago;
use App\Models\NotaVenta;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::all();
        return view('dashboard.pagos.index', compact('pagos'));
    }

    public function create()
    {
        // Obtener las ventas que tiene su estado de pago en false
        $ventas = NotaVenta::whereHas('pagos', function ($query) {
            $query->where('estado', false);
        })->get();
        $metodosPago = MetodoPago::all();

        return view('dashboard.pagos.create', compact('ventas', 'metodosPago'));
    }

    public function createPago(string $id)
    {
        $pago = Pago::find($id);

        if (!$pago) {
            session()->flash('error', 'No se encontró el pago');
            return redirect()->route('pagos.index');
        }

        $venta = $pago->notaVenta;
        // $productos = $venta->productosAlmacen;
        $productos = $venta->productosAlmacen()->with(['producto', 'almacen'])->get();
        $metodosPago = MetodoPago::all();
        $historialPagos = $venta->pagos;
        return view('dashboard.pagos.create_pago', compact('venta', 'metodosPago', 'pago', 'productos', 'historialPagos'));
    }

    public function store(StorePagoRequest $request) {}

    public function show(Pago $pago)
    {
        //
    }

    public function edit(Pago $pago)
    {
        //
    }

    public function update(UpdatePagoRequest $request, string $id)
    {
        // Encuentra el pago
        $pago = Pago::find($id);

        if (!$pago) {
            return redirect()->route('pagos.index')->with('error', 'No se encontró el pago');
        }

        // Usa una transacción para garantizar consistencia
        DB::beginTransaction();
        try {
            // Obtener el saldo actual
            $saldo = $pago->notaVenta->monto_total - $pago->notaVenta->pagos->where('estado', true)->sum('monto');

            if ($saldo < $request->efectivo) {
                return redirect()->route('pagos.createPago', $pago->id)->with('error', 'El monto ingresado es mayor al saldo pendiente');
            }

            // Actualiza el pago
            $pago->update([
                'monto' => $request->efectivo,
                // 'fecha_pago' => now(),
                'metodo_pago_id' => $request->metodo_pago_id,
                'estado' => true,
            ]);

            // Recalcular el saldo después de la actualización
            $montoPagado = Pago::where('venta_id', $pago->venta_id)
                ->where('estado', true)
                ->sum('monto');

            $saldo = $pago->notaVenta->monto_total - $montoPagado;

            // Si hay saldo pendiente, crea un nuevo pago
            if ($saldo > 0) {
                Pago::create([
                    'monto' => $saldo,
                    'fecha_pago' => now(),
                    'venta_id' => $pago->venta_id,
                    'estado' => false,
                    'descripcion' => 'Pago pendiente por la venta ' . $pago->notaVenta->id,
                ]);
            }

            // Confirma la transacción
            DB::commit();
            return redirect()->route('pagos.index')->with('guardado', 'El pago ha sido registrado correctamente');
        } catch (\Exception $e) {
            // Si hay un error, revierte la transacción
            DB::rollBack();
            return redirect()->route('pagos.index')->with('error', 'Ocurrió un error al procesar el pago: ' . $e->getMessage());
        }
    }


    // public function update(UpdatePagoRequest $request, string $id)
    // {
    //     // dd($request->all());
    //     $pago = Pago::find($id);

    //     if (!$pago) {
    //         return redirect()->route('pagos.index')->with('error', 'No se encontró el pago');
    //     }

    //     // Obtener el saldo 
    //     $saldo = $pago->notaVenta->monto_total - $pago->notaVenta->pagos->where('estado', true)->sum('monto');
    //     if ($saldo < $request->efectivo) {
    //         return redirect()->route('pagos.createPago', $pago->id)->with('error', 'El monto ingresado es mayor al saldo pendiente');
    //     }

    //     $pago->update([
    //         'monto' => $request->efectivo,
    //         'fecha_pago' => now(),
    //         'metodo_pago_id' => $request->metodo_pago_id,
    //         'estado' => true,
    //     ]);

    //     // Si el saldo es mayor a 0, se crea un nuevo pago con el saldo pendiente
    //     $saldo = $pago->notaVenta->monto_total - $pago->notaVenta->pagos->where('estado', true)->sum('monto');

    //     dd($saldo);
    //     if ($saldo > 0) {
    //         Pago::create([
    //             'monto' => $saldo,
    //             'fecha_pago' => now(),
    //             'venta_id' => $pago->venta_id,
    //             'estado' => false,
    //             'descripcion' => 'Pago pendiente por la venta ' . $pago->notaVenta->id,
    //         ]);
    //     } 

    //     return redirect()->route('pagos.index')->with('guardado', 'El pago ha sido registrado correctamente');
    // }

    public function destroy(Pago $pago)
    {
        //
    }
}
