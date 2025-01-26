<x-layouts.app>

    <x-layouts.content title="Pagos" subtitle="" name="Pagos">

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-plus-circle fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Agregar Pago</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{route('pagos.update', $pago['id'])}}" method="post">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre" class="control-label"><strong>Nombre del cliente:</strong></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                           value="{{ $pago['compra']['proveedor']['nombre_empresa'] }} - {{ $pago['compra']['proveedor']['nombre_proveedor'] }}" readonly>
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
                                                        @foreach ($compra->productos as $producto)
                                                        <tr>
                                                            <td class="align-middle">{{ $producto['nombre'] }}</td>
                                                            <td class="align-middle">{{ $producto['pivot']['cantidad'] }}</td>
                                                            <td class="align-middle">{{ 'Bs. ' . $producto['pivot']['precio_unitario'] }}</td>
                                                            <td class="align-middle">{{ 'Bs. ' . $producto['pivot']['subtotal'] }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Subtotal:</strong></label>
                                        <div class="input-group mt-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs</span>
                                            </div>
                                            <input type="text" class="form-control"
                                                name="subtotal" id="subtotal" value="" readonly>
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
                                            <input type="text" class="form-control"
                                            name="descuento" id="descuento" value="{{ $pago['compra']['descuento'] }}" readonly>
                                        </div>
                                    </div>
                                </div> --}}
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Metodo de Pago:</strong></label>
                                        <select class="form-control" name="metodo_pago_id" id="metodo_pago_id">
                                            <option value="">Seleccione un método de pago</option>
                                            @foreach ($metodosPago as $metodoPago)
                                                <option value="{{ $metodoPago['id'] }}"
                                                    @if ($pago['metodo_pago_id'] == $metodoPago['id'])
                                                        selected
                                                    @endif
                                                >
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
                                        <label><strong>Monto Total a Pagar:</strong></label>
                                        <div class="input-group mt-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs</span>
                                            </div>
                                            <input type="text" class="form-control"
                                                name="monto" id="monto" value="{{ formatearNumero($pago['monto'])}}" readonly>
                                            <input type="hidden" id="montoTotal" name="montoTotal" value="{{ $pago['monto'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Efectivo Recibido:</strong></label>
                                        <div class="input-group mt-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs</span>
                                            </div>
                                            <input class="form-control"
                                                name="efectivo" placeholder="0.00" id="efectivo"
                                                @if ($pago['estado'])
                                                type="text"
                                                    readonly value=""
                                                @else
                                                    type="number" value="{{ old('efectivo') }}"
                                                @endif
                                            >
                                        </div>
                                        @error('efectivo')
                                            <span class="error text-danger">* {{ $message }}</span>
                                        @enderror
                                        <span id="mensajeError" class="error text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Saldo:</strong></label>
                                        <div class="input-group mt-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs</span>
                                            </div>
                                            <input type="text" class="form-control"
                                                name="saldo" id="saldo"
                                                {{-- @if ($pago['estado'])
                                                    value="{{ formatearNumero($pago['factura']['saldo'])}}"
                                                @endif --}}
                                                placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion" class="control-label">
                                            <strong>Descripción:</strong>
                                        </label>
                                        <textarea class="form-control" name="descripcion" id="descripcion" rows="5"
                                            @if ($pago['estado']) 
                                                readonly  
                                            @endif>{{ $pago['descripcion'] }}</textarea>
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
            $(document).ready(function () {

                function actualizarSaldo() {
                    let montoTotal = parseFloat($("#montoTotal").val());
                    let efectivoRecibido = parseFloat($("#efectivo").val());

                    // Verificar si el efectivo recibido es mayor o igual al monto total
                    if (!isNaN(montoTotal) && !isNaN(efectivoRecibido) && efectivoRecibido >= montoTotal) {
                        let saldo = efectivoRecibido - montoTotal; // Calcular el saldo
                        $("#saldo").val(saldo.toFixed(2)); // Mostrar el saldo con dos decimales
                        $("#mensajeError").text("");
                        $("#guardarPago").prop('disabled', false); // Habilitar el botón de guardar
                    } else {
                        if (!isNaN(efectivoRecibido)) {
                            $("#mensajeError").text("El efectivo recibido no puede ser menor al monto total.");
                        }
                        $("#saldo").val(''); // Limpiar el campo de saldo si no cumple la condición
                        // $("#guardarPago").prop('disabled', true); // Deshabilitar el botón de guardar
                    }
                }

                // Configurar el evento de cambio en el campo de "Efectivo Recibido"
                $("#efectivo").on("change", function () {
                    actualizarSaldo(); // Llamar a la función al cambiar el valor
                });

                actualizarSaldo(); // Llamar a la función al cargar la página

            });
        </script>
    @endpush

</x-layouts.app>
