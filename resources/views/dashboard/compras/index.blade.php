<x-layouts.app>
    <x-layouts.content title="Compras" subtitle="" name="Compras">
        <div class="row">
            <div class="col-12">
                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        <a href="{{ route('compras.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nueva Compra
                        </a>
                    </div>
                </div>
                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-compras" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Monto Total</th>
                                    <th scope="col">Fecha y Hora</th>
                                    <th scope="col">Estado de Entrega</th>
                                    {{-- <th scope="col">Estado de Pago</th> --}}
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compras as $compra)
                                <tr class="text-nowrap text-center">
                                    <th scope="row" class="align-middle">{{ $compra['id'] }}</th>
                                    <td class="align-middle">{{ $compra['proveedor']['nombre_empresa'] }} - {{ $compra['proveedor']['nombre_encargado'] }}
                                    </td>
                                    <td class="align-middle">{{ $compra['usuario']['nombre'] }} {{ $compra['usuario']['apellido'] }}
                                    <td class="align-middle">Bs. {{ formatearNumero($compra['monto_total']) }}</td>
                                    <td class="align-middle">{{ formatearFecha($compra['fecha_compra']) }}</td>
                                    <td class="align-middle">
                                        @if ($compra['estado'])
                                        <span class="text-success py-1 px-2 rounded-lg d-inline-block"
                                            style="background-color: #d4edda;">Confirmada</span>
                                        @else
                                        <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                            style="background-color: #ffeeba;">Pendiente</span>
                                        @endif
                                    </td>
                                    {{-- <td class="align-middle">
                                        @if ($compra['pago'] && $compra['pago']['estado'])
                                        <span class="text-success py-1 px-2 rounded-lg d-inline-block"
                                            style="background-color: #d4edda;">Pagado</span>
                                        @else
                                        <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                            style="background-color: #ffeeba;">Pendiente</span>
                                        @endif
                                    </td> --}}
                                    <td class="align-middle text-nowrap">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('compras.show', $compra['id']) }}" title="Ver detalles"
                                                class="btn btn-sm btn-warning mx-1">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if (!$compra['estado'])
                                            <a href="{{ route('compras.edit', $compra['id']) }}" title="Editar"
                                                class="btn btn-sm btn-primary mx-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif
                                            
                                            <form id="formDeleteCompra_{{ $compra['id'] }}"
                                                action="{{route('compras.delete', $compra['id']) }}" method="post">
                                                @csrf
                                                <button type="button" title="Eliminar"
                                                    onclick="confirmDelete({{ $compra['id'] }})" title="Eliminar"
                                                    class="btn btn-sm btn-danger mx-1">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            
                                            {{-- @if (!$compra['estado']) --}}
                                            <form id="formConfirmarCompra_{{ $compra['id'] }}"
                                            action="{{route('compras.confirmarCompra', $compra['id']) }}" method="post">
                                                @csrf
                                                <button type="button" title="Confirmar entrega"
                                                    onclick="confirmEntrega({{ $compra['id'] }})" title="Confirmar"
                                                    class="btn btn-sm btn-success mx-1">
                                                    <i class="fas fa-check-square"></i>
                                                </button>
                                            </form>
                                            {{-- @endif --}}
                                        </div>
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

    @push('js')
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
                      var formId = 'formDeleteCompra_' + id;
                      var form = document.getElementById(formId);
                      form.submit(); // Envía el formulario si el usuario confirma
                  }
              });
          }
          
          function confirmEntrega(id) {
              Swal.fire({
                    title: '¿Confirmar entrega?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#556ee6',
                    cancelButtonColor: '#f46a6a',
                    confirmButtonText: 'Sí, confirmar entrega',
                    cancelButtonText: 'Cancelar'
              }).then((result) => {
                  if (result.isConfirmed) {
                      var formId = 'formConfirmarCompra_' + id;
                      var form = document.getElementById(formId);
                      form.submit(); // Envía el formulario si el usuario confirma
                  }
              });
          }
    </script>
    @endpush

</x-layouts.app>