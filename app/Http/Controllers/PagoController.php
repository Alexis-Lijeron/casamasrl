<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use App\Models\MetodoPago;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::all();
        return view('dashboard.pagos.index', compact('pagos'));
    }

    public function create()
    {
        //
    }
    
    public function createPago(string $id) {
        $pago = Pago::find($id);
        
        // if ($pago->compra) {
            $compra = $pago->compra;
        // } else {
        //     $venta = $pago->venta;
        // }
        
        $productos = $compra->productos;
        // dd($productos);
        
        $metodosPago = MetodoPago::all();
        return view('dashboard.pagos.create_pago', compact('compra', 'metodosPago', 'pago'));
    }

    public function store(StorePagoRequest $request)
    {
        //
    }

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
        $pago = Pago::find($id);
        
        if (!$pago) {
            return redirect()->route('pagos.index')->with('error', 'No se encontró el pago');
        }
        
        $pago->update([
            // 'monto' => $request->monto,
            // 'fecha' => $request->fecha,
            'metodo_pago_id' => $request->metodo_pago_id,
            'estado' => true,
        ]);
        return redirect()->route('pagos.index')->with('guardado', 'El pago ha sido registrado correctamente');
    }

    public function destroy(Pago $pago)
    {
        //
    }
}
