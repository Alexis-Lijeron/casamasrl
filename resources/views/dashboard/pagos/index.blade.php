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
                            <td class="align-middle text-nowrap">
                                <a href="{{ route('pagos.createPago', $pago['id']) }}" title="Pagar" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-dollar-sign"></i>
                                </a>

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

    {{-- @push('js')
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#556ee6',
                    cancelButtonColor: '#f46a6a',
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formId = 'formDeleteOrden_' + id;
                        var form = document.getElementById(formId);
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            }
        </script>

        <script>
            function actualizarEstado(ordenId) {
                var nuevoEstado = $("#estado_" + ordenId).val();
                const urlApi = "{{ env('URL_SERVER_API') }}";
    const url = `${urlApi}/orden-trabajos/${ordenId}`;
    console.log(nuevoEstado);

    fetch(url, {
    method: "POST",
    headers: {
    "Content-Type": "application/json",
    "X-CSRF-TOKEN": "{{ csrf_token() }}",
    },
    body: JSON.stringify({
    estado: nuevoEstado,
    }),
    })
    .then(response => {
    if (response.ok) {
    return response.json();
    } else {
    throw new Error('Error al actualizar el estado de la orden de trabajo.');
    }
    })
    .then(data => {
    console.log(data);
    Swal.fire({
    icon: 'success',
    title: '¡Estado Actualizado!',
    text: 'El estado de la orden de trabajo ha sido actualizado correctamente.',
    timer: 1500
    });
    })
    .catch(error => {
    console.error('Error:', error);
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Error al actualizar el estado de la orden de trabajo.',
    timer: 1500
    });
    });
    }
    </script>
    @endpush --}}

</x-layouts.app>