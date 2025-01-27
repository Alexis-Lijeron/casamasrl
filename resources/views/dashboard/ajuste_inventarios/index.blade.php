<x-layouts.app>
    <x-layouts.content title="Ajustes de Inventario" subtitle="" name="Ajustes de Inventario">
        <div class="row">
            <div class="col-12">
               
        <div class="card-box">
            <div class="table-responsive">
                <table id="table-ajustes" class="table table-hover mb-0 dts">
                    <thead class="bg-dark text-center text-white text-nowrap">
                        <tr style="cursor: pointer">
                            <th scope="col">ID</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Detalle</th>
                            <th scope="col">Fecha y Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ajustes as $ajuste)
                        <tr class="text-nowrap text-center">
                            <th scope="row" class="align-middle">{{ $ajuste['id'] }}</th>
                            <td class="align-middle">{{ $ajuste['usuario']['nombre'] }} {{ $ajuste['usuario']['apellido'] }}
                            <td class="align-middle">{{ $ajuste['tipo'] }}</td>
                            {{-- <td class="align-middle">Bs. {{ formatearNumero($ajuste['monto_total']) }}</td> --}}
                            <td class="align-middle">{{ formatearFecha($ajuste['fecha']) }}</td>
                            <td class="align-middle">
                                @foreach ($ajuste->productosAlmacen as $producto)
                                <li>{{ $producto->producto->nombre }} - <span class="badge badge-secondary">{{ $producto->pivot->cantidad }}</span></li>
                                @endforeach
                            </td>
                            <td class="align-middle">{{ $ajuste['descripcion'] }}</td>
                            <td class="align-middle text-nowrap">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('ajustes.show', $ajuste['id']) }}" title="Ver detalles"
                                        class="btn btn-sm btn-warning mx-1">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- <a href="{{ route('ajustes.edit', $ajuste['id']) }}" title="Editar"
                                    class="btn btn-sm btn-primary mx-1">
                                    <i class="fas fa-edit"></i>
                                    </a>

                                    <form id="formDeleteCompra_{{ $ajuste['id'] }}"
                                        action="{{route('ajustes.delete', $ajuste['id']) }}" method="post">
                                        @csrf
                                        <button type="button" title="Eliminar"
                                            onclick="confirmDelete({{ $ajuste['id'] }})" title="Eliminar"
                                            class="btn btn-sm btn-danger mx-1">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form> --}}
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
