<x-layouts.app>

    <x-layouts.content title="Pagos" subtitle="" name="Pagos">

        <div class="row">
            <div class="col-12">

                {{-- <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        <a href="{{ route('pagos.create') }}" class="btn btn-primary waves-effect waves-light">
                <i class="fas fa-plus-circle"></i>&nbsp;
                Nuevo Pago
                </a>
            </div>
        </div> --}}

        <div class="card-box">
            <div class="table-responsive">
                <table id="table-ordenes" class="table table-hover mb-0 dts">
                    <thead class="bg-dark text-center text-white text-nowrap">
                        <tr style="cursor: pointer">
                            <th scope="col">ID</th>
                            {{-- <th scope="col">Usuario</th> --}}
                            <th scope="col">ID venta</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha y Hora</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Método de Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                        <tr class="text-nowrap text-center">
                            <th scope="row" class="align-middle" style="width: 120px">
                                {{ $pago['id'] }}
                            </th>
                            <td class="align-middle">
                                Venta #{{ $pago['notaVenta']['id'] }}
                            </td>
                            <td class="align-middle">
                                {{ $pago['notaVenta']['cliente']['nombre'] }}
                                {{ $pago['notaVenta']['cliente']['apellido'] }}
                            </td>
                            <td class="align-middle">
                                {{ $pago['descripcion'] }}
                            </td>
                            <td class="align-middle">
                                {{ formatearFecha($pago['fecha_pago']) }}
                            </td>
                            <td class="align-middle">
                                {{ 'Bs. ' . formatearNumero($pago['monto']) }}
                            </td>
                            <td class="align-middle">
                                @if ($pago['estado'])
                                <span class="text-success py-1 px-2 rounded-lg d-inline-block"
                                    style="background-color: #d4edda; width: 90px">Pagado</span>
                                @else
                                <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                    style="background-color: #ffeeba; width: 90px">Pendiente</span>
                                @endif
                            </td>
                            <td>
                                {{ $pago['metodoPago']['nombre'] ?? 'Sin Asignar' }} <!-- Mostrar el método de pago -->
                            </td>
                            <td class="align-middle text-nowrap">
                                <a href="{{ route('pagos.createPago', $pago['id']) }}" title="Pagar" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-dollar-sign"></i>
                                </a>
                                <!-- Botón para pago QR -->
                                <button class="btn btn-sm btn-outline-primary" title="Pagar con QR"
                                    onclick="generarQR({{ $pago['id'] }}, '{{ $pago['notaVenta']['cliente']['nombre'] }}', {{ $pago['monto'] }})">
                                    <i class="fas fa-qrcode"></i>
                                </button>
                                {{-- <a href="{{ route('pagos.createFactura' ,$pago['id'])}}" class="btn btn-sm btn-outline-danger"
                                @if (!$pago['estado'])
                                title="No tiene factura"
                                onclick="return false;"
                                @else
                                title="Factura"
                                @endif
                                >
                                <i class="fas fa-file-pdf"></i>
                                </a> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        </div>
        </div>

    </x-layouts.content>
    <!-- Modal para mostrar el código QR -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">Código QR para Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Escanea el código QR para realizar el pago:</p>
                    <img id="qrImage" src="" alt="QR Code" class="img-fluid">
                </div>
                <td class="align-middle text-nowrap">
                    <button id="verifyTransactionButton" class="btn btn-info" type="button"
                        onclick="verificarTransaccion(this)"
                        data-id-pago="{{ $pago['id'] }}"
                        data-transaccion-id="{{ $pago['transaccion_id'] }}">
                        Verificar Estado de Transacción
                    </button>
                </td>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        function generarQR(idPago, nombreUsuario, monto) {
            const url = "{{ route('pagos.generarQR') }}";

            const data = {
                tcCommerceID: "{{ env('PAGOFACIL_COMMERCE_ID') }}",
                tcNroPago: String(Date.now()),
                tcNombreUsuario: nombreUsuario,
                tnCiNit: parseInt(9999999),
                tnTelefono: parseInt(70000000),
                tcCorreo: "micorreo@mail.com",
                tcCodigoClienteEmpresa: "9",
                tnMontoClienteEmpresa: parseFloat(monto).toFixed(2),
                tnMoneda: 2,
                tcUrlCallBack: "https://tudominio.com/callback",
                tcUrlReturn: "https://tudominio.com/return",
                taPedidoDetalle: [{
                    Serial: 1,
                    Producto: "Pago de servicio",
                    Cantidad: 1,
                    Precio: parseFloat(monto).toFixed(2),
                    Descuento: 0,
                    Total: parseFloat(monto).toFixed(2)
                }]
            };

            fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data);

                    if (data.error === 0) {
                        // Extraer la primera parte del `values` como el ID de la transacción
                        const values = data.values.split(";");
                        const transaccionId = values[0]; // Primer valor antes del punto y coma

                        // Mostrar el QR
                        const qrData = JSON.parse(values[1]);
                        const qrImageBase64 = "data:image/png;base64," + qrData.qrImage;
                        document.getElementById("qrImage").src = qrImageBase64;

                        // Guardar el ID en el botón de verificación
                        document.getElementById("verifyTransactionButton").setAttribute("data-transaccion-id", transaccionId);

                        // Mostrar el modal
                        var myModal = new bootstrap.Modal(document.getElementById("qrModal"));
                        myModal.show();
                    } else {
                        Swal.fire("Error", "No se pudo generar el QR: " + data.messageSistema, "error");
                    }
                })
                .catch(error => {
                    console.error("Error al generar QR:", error);
                    Swal.fire("Error", "Hubo un problema al generar el QR.", "error");
                });
        }

        function verificarTransaccion(button) {
            const transaccionId = button.getAttribute("data-transaccion-id");

            if (!transaccionId) {
                Swal.fire("Error", "No se encontró un ID de transacción válido.", "error");
                return;
            }

            const url = "{{ route('pagos.consultarTransaccion') }}";

            fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        transaccionDePago: transaccionId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Estado de la transacción:", data);

                    if (data.error === 0) {
                        const estado = data.values?.messageEstado || "Estado desconocido";

                        Swal.fire({
                            icon: "success",
                            title: "Estado de Transacción",
                            text: `Estado: ${estado}`,
                        }).then(() => {
                            // Solo actualiza si el estado contiene "COMPLETADO - PROCESADO"
                            if (estado.includes("COMPLETADO - PROCESADO")) {
                                actualizarEstadoPago(button.getAttribute("data-id-pago"), estado);
                            } else {
                                Swal.fire("Aviso", "El pago no está confirmado como COMPLETADO - PROCESADO.", "info");
                            }
                        });
                    } else {
                        Swal.fire("Error", data.messageSistema || "No se pudo verificar la transacción.", "error");
                    }
                })
                .catch(error => {
                    console.error("Error al verificar la transacción:", error);
                    Swal.fire("Error", "Hubo un problema al verificar la transacción.", "error");
                });
        }


        function actualizarEstadoPago(idPago, estadoTransaccion) {
            const url = "{{ route('pagos.actualizarEstado') }}";

            fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        idPago: idPago,
                        estadoTransaccion: estadoTransaccion, // Asegurarse de pasar el estado correctamente
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error === 0) {
                        Swal.fire("Éxito", "El estado del pago ha sido actualizado.", "success");

                        // Recargar la tabla para reflejar los cambios
                        location.reload();
                    } else {
                        Swal.fire("Error", data.message || "No se pudo actualizar el estado del pago.", "error");
                    }
                })
                .catch(error => {
                    console.error("Error al actualizar el estado del pago:", error);
                    Swal.fire("Error", "Hubo un problema al actualizar el estado del pago.", "error");
                });
        }
    </script>
    @endpush
</x-layouts.app>