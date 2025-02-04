<x-layouts.app>
    <x-layouts.content title="Ventas" subtitle="Detalles de la venta" name="Ventas">
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <!-- Encabezado -->
                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-eye fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Detalles de la venta</h3>
                        <a href="{{ route('ventas.index') }}" class="btn btn-primary waves-effect waves-light float-right">
                            <i class="fas fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>

                    <!-- Datos principales de la venta -->
                    <div class="row px-4">
                        <div class="col-md-4">
                            <label class="font-17 d-block"><strong>Fecha y Hora:</strong></label>
                            <span class="font-17">{{ formatearFecha($venta->fecha_venta) }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="font-17 d-block"><strong>Cliente:</strong></label>
                            <span class="font-17 d-block">
                                {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label class="font-17 d-block"><strong>Registrado por:</strong></label>
                            <span class="font-17">
                                {{ $venta->usuario->nombre }} {{ $venta->usuario->apellido }}
                            </span>
                        </div>
                    </div>

                    <!-- Estado de Pago -->
                    <div class="row px-4 mt-2">
                        <div class="col-md-4">
                            <label class="font-17 d-block"><strong>Estado de Pago:</strong></label>
                            @php
                            $estadoPago = $venta->estadoPago();
                            @endphp
                            @if ($estadoPago === 'Pagado')
                            <span class="text-success font-17">Pagado</span>
                            @elseif ($estadoPago === 'Parcialmente Pagado')
                            <span class="text-warning font-17">Parcialmente Pagado</span>
                            @else
                            <span class="text-danger font-17">Pendiente</span>
                            @endif
                        </div>
                    </div>

                    <!-- Detalle de productos vendidos -->
                    <div class="row px-4 mt-3">
                        <div class="form-group col-md-12">
                            <table class="table table-bordered table-responsive-lg">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th class="text-center">Producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Precio Unitario</th>
                                        <th class="text-center">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productosAsociados as $producto)
                                    <tr>
                                        <td class="align-middle text-center">{{ $producto['nombre'] }}</td>
                                        <td class="align-middle text-center">{{ $producto['cantidad'] }}</td>
                                        <td class="align-middle text-center">Bs. {{ formatearNumero($producto['precio_venta']) }}</td>
                                        <td class="align-middle text-center">Bs. {{ formatearNumero($producto['subtotal']) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="align-middle text-center text-uppercase font-17"><strong>Total:</strong></td>
                                        <td class="align-middle text-center font-17"><strong>Bs. {{ formatearNumero($venta->monto_total) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a href="{{ route('ventas.imprimir', $venta->id) }}" target="_blank" class="btn btn-secondary no-print">
                        <i class="fas fa-print"></i> Imprimir Factura
                    </a>

                </div>
            </div>
        </div>
    </x-layouts.content>
</x-layouts.app>