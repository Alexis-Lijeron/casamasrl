<x-layouts.app>

    <x-layouts.content title="Pagos" subtitle="" name="Pagos">

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-plus-circle fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Agregar Pago</h3>
                    </div>

                    <hr class="mx-4" style="border-color: #F0F0F0">

                    <form class="px-4 pt-2 pb-2" action="{{route('pagos.update', $pago['id'])}}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre" class="control-label"><strong>Nombre del
                                                cliente:</strong></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            value="{{ $pago['notaVenta']['cliente']['nombre'] }} - {{ $pago['notaVenta']['cliente']['apellido'] }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion" class="control-label">
                                            <strong>Detalle:</strong>
                                        </label>
                                        <div id="datosProductos">
                                            <table id="tablaProductos" class="table table-bordered text-center">
                                                <thead style="background-color: #3a415a; color: white;">
                                                    <tr>
                                                        <th class="align-middle" colspan="4">Productos</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle">Nombre</th>
                                                        <th class="align-middle">Cantidad</th>
                                                        <th class="align-middle">Precio Unitario</th>
                                                        <th class="align-middle">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($productos as $detalle)
                                                    <tr>
                                                        <td class="align-middle">{{ $detalle['producto']['nombre'] }}
                                                        </td>
                                                        <td class="align-middle">{{ $detalle['pivot']['cantidad'] }}
                                                        </td>
                                                        <td class="align-middle">Bs. {{
                                                            formatearNumero($detalle['pivot']['precio_venta']) }}</td>
                                                        <td class="align-middle">Bs. {{
                                                            formatearNumero($detalle['pivot']['precio_venta'] *
                                                            $detalle['pivot']['cantidad']) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                @if ($historialPagos->isNotEmpty())
                                <div class="col-md-12 mt-4">
                                    <h4>Historial de Pagos</h4>
                                    <table class="table table-bordered text-center">
                                        <thead style="background-color: #3a415a; color: white;">
                                            <tr>
                                                <th>#</th>
                                                <th>Método de Pago</th>
                                                <th>Monto</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($historialPagos as $index => $historialPago)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($historialPago->metodoPago)
                                                    {{ $historialPago->metodoPago->nombre }}
                                                    @else
                                                    <span class="text-muted">No asignado</span>
                                                    @endif
                                                </td>
                                                <td>Bs. {{ number_format($historialPago->monto, 2) }}</td>
                                                <td>{{ $historialPago->created_at->format('d/m/Y H:i:s') }}</td>
                                                <td>
                                                    @if ($historialPago->estado)
                                                    <span class="badge badge-success">Pagado</span>
                                                    @else
                                                    <span class="badge badge-warning">Pendiente</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5">No hay pagos registrados.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                            </div>

                            <div class="col-md-6">
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Subtotal:</strong></label>
                                        <div class="input-group mt-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs</span>
                                            </div>
                                            <input type="text" class="form-control" name="subtotal" id="subtotal"
                                                value="" readonly>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Descuento Aplicado:</strong></label>
                                        <div class="input-group mt-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" class="form-control" name="descuento" id="descuento"
                                                value="{{ $pago['venta']['descuento'] }}" readonly>
                            </div>
                        </div>
                </div> --}}

                @if ($pago['estado'])
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Fecha de Pago:</strong></label>
                        <input type="text" class="form-control" name="fecha_pago" id="fecha_pago"
                            value="{{ formatearFecha($pago['fecha_pago']) }}" readonly>
                    </div>
                </div>
                @endif

                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Metodo de Pago:</strong></label>
                        <select class="form-control" name="metodo_pago_id" id="metodo_pago_id" @if($pago['estado']) disabled @endif>
                            <option value="">Seleccione un método de pago</option>
                            @foreach ($metodosPago as $metodoPago)
                            <option value="{{ $metodoPago['id'] }}"
                                @if($pago['metodo_pago_id']==$metodoPago['id']) selected @endif>
                                {{ $metodoPago['nombre'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('metodo_pago_id')
                        <span class="error text-danger">* {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>
                                @if ($pago['estado'])
                                Monto Pagado:
                                @else
                                Monto Total a Pagar:
                                @endif
                            </strong></label>
                        <div class="input-group mt-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Bs</span>
                            </div>
                            <input type="text" class="form-control" name="monto" id="monto"
                                value="{{ formatearNumero($pago['monto'])}}" readonly>
                            <input type="hidden" id="montoTotal" name="montoTotal"
                                value="{{ $pago['monto'] }}">
                        </div>
                    </div>
                </div>

                @if (!$pago['estado'])
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Efectivo Recibido:</strong></label>
                        <div class="input-group mt-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Bs</span>
                            </div>
                            <input class="form-control" name="efectivo" placeholder="0.00" id="efectivo"
                                @if ($pago['estado']) type="text" readonly value="" @else type="number"
                                value="{{ old('efectivo') }}" @endif>
                        </div>
                        @error('efectivo')
                        <span class="error text-danger">* {{ $message }}</span>
                        @enderror
                        <span id="mensajeError" class="error text-danger"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Saldo pendiente:</strong></label>
                        <div class="input-group mt-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Bs</span>
                            </div>
                            <input type="text" class="form-control" name="saldo" id="saldo" {{-- @if
                                                ($pago['estado'])
                                                value="{{ formatearNumero($pago['factura']['saldo'])}}" @endif --}}
                                placeholder="0.00" readonly>
                        </div>
                    </div>
                </div>
                @endif


                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descripcion" class="control-label">
                            <strong>Descripción:</strong>
                        </label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="5"
                            @if($pago['estado']) readonly @endif>{{ $pago['descripcion'] }}</textarea>
                        @error('descripcion')
                        <span class="error text-danger">* {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-right px-2 m-b-0">
            <a href="{{ route('pagos.index') }}" class="btn btn-danger waves-effect m-l-5">
                @if ($pago['estado'])
                Cerrar
                @else
                Cancelar
                @endif
            </a>
            @if (!$pago['estado'])
            <button class="btn btn-primary waves-effect waves-light" id="guardarPago" type="submit">
                Guardar
            </button>
            @endif
        </div>

        </form>

        </div>
        </div>
        </div>

    </x-layouts.content>

    @push('js')
    <script>
        $(document).ready(function() {

            function actualizarSaldo() {
                let montoTotal = parseFloat($("#montoTotal").val());
                let efectivoRecibido = parseFloat($("#efectivo").val());

                // Verificar si el efectivo recibido es mayor o igual al monto total
                if (!isNaN(montoTotal) && !isNaN(efectivoRecibido) && efectivoRecibido >= 0) {
                    let saldo = montoTotal - efectivoRecibido; // Calcular el saldo

                    if (saldo < 0) {
                        saldo = 0; // Si el saldo es negativo, asignar 0
                    }

                    $("#saldo").val(saldo.toFixed(2)); // Mostrar el saldo con dos decimales
                    $("#mensajeError").text("");
                    $("#guardarPago").prop('disabled', false); // Habilitar el botón de guardar
                } else {
                    if (!isNaN(efectivoRecibido) && efectivoRecibido < 0) {
                        $("#mensajeError").text("El efectivo recibido debe ser mayor o igual a 0");
                    }
                    $("#saldo").val(''); // Limpiar el campo de saldo si no cumple la condición
                    // $("#guardarPago").prop('disabled', true); // Deshabilitar el botón de guardar
                }
            }

            // Configurar el evento de cambio en el campo de "Efectivo Recibido"
            $("#efectivo").on("change", function() {
                actualizarSaldo(); // Llamar a la función al cambiar el valor
            });

            actualizarSaldo(); // Llamar a la función al cargar la página

        });
    </script>
    @endpush

</x-layouts.app>