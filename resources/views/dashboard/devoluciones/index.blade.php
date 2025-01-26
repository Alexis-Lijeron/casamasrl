<x-layouts.app>
  <x-layouts.content title="Devoluciones" subtitle="" name="Devoluciones">
      <div class="row">
          <div class="col-12">
              {{-- <div class="mb-2 d-flex justify-content-between">
                  <div class="form-group">
                      <a href="{{ route('devoluciones.create') }}" class="btn btn-primary waves-effect waves-light">
                          <i class="fas fa-plus-circle"></i>&nbsp;
                          Nueva Devolución
                      </a>
                  </div>
              </div> --}}
              <div class="card-box">
                  <div class="table-responsive">
                      <table id="table-devoluciones" class="table table-hover mb-0 dts">
                          <thead class="bg-dark text-center text-white text-nowrap">
                              <tr style="cursor: pointer">
                                  <th scope="col">ID</th>
                                  <th scope="col">Usuario</th>
                                  <th scope="col">Motivo</th>
                                  <th scope="col">Monto Total</th>
                                  <th scope="col">Fecha y Hora</th>
                                  <th>Acciones</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($devoluciones as $devolucion)
                              <tr class="text-nowrap text-center">
                                  <th scope="row" class="align-middle">{{ $devolucion['id'] }}</th>
                                  <td class="align-middle">{{ $devolucion['usuario']['nombre'] }} {{ $devolucion['usuario']['apellido'] }}
                                  <td class="align-middle">{{ $devolucion['motivo'] }}</td>
                                  <td class="align-middle">Bs. {{ formatearNumero($devolucion['monto_total']) }}</td>
                                  <td class="align-middle">{{ formatearFecha($devolucion['fecha_devolucion']) }}</td>
                                  <td class="align-middle text-nowrap">
                                      <div class="d-flex justify-content-center">
                                          <a href="{{ route('devoluciones.show', $devolucion['id']) }}" title="Ver detalles"
                                              class="btn btn-sm btn-warning mx-1">
                                              <i class="fas fa-eye"></i>
                                          </a>

                                          <a href="{{ route('devoluciones.edit', $devolucion['id']) }}" title="Editar"
                                              class="btn btn-sm btn-primary mx-1">
                                              <i class="fas fa-edit"></i>
                                          </a>
                                          
                                          <form id="formDeleteCompra_{{ $devolucion['id'] }}"
                                              action="{{route('devoluciones.delete', $devolucion['id']) }}" method="post">
                                              @csrf
                                              <button type="button" title="Eliminar"
                                                  onclick="confirmDelete({{ $devolucion['id'] }})" title="Eliminar"
                                                  class="btn btn-sm btn-danger mx-1">
                                                  <i class="fas fa-trash-alt"></i>
                                              </button>
                                          </form>
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
        
  </script>
  @endpush

</x-layouts.app>