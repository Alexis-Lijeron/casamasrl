<x-layouts.app>

    <x-layouts.content title="Almacenes" subtitle="" name="Almacenes">

        <div class="row">
            <div class="col-12">

                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        @if(auth()->user()->hasPermission('almacenes.crear'))
                        <a href="{{ route('almacenes.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nuevo Almacen
                        </a>
                        @endif
                    </div>
                </div>

                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-almacenes" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Productos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($almacenes as $almacen)
                                <tr class="text-nowrap text-center">
                                    <th scope="row" class="align-middle">{{$almacen['id']}}</th>
                                    <td class="align-middle">{{$almacen['nombre']}}</td>
                                    <td class="align-middle">
                                        {{$almacen['descripcion'] ?? '-- Sin descripción --'}}
                                    </td>
                                    <td class="align-middle">
                                        @foreach ($almacen->productos as $producto)
                                        <li>{{ $producto->nombre }} - <span class="badge"
                                                @if(obtenerStockDisponibleAlmacen($producto->id, $almacen->id) == 0)
                                                style="background-color: #f46a6a"
                                                @else
                                                style="background-color: #556ee6"
                                                @endif
                                                >Stock {{
                                                obtenerStockDisponibleAlmacen($producto->id, $almacen->id) }}</span>
                                        </li>
                                        @endforeach
                                    </td>
                                    <td class="align-middle text-nowrap" style="width: 150px;">
                                        <div class="d-flex justify-content-center">
                                            @if(auth()->user()->hasPermission('almacenes.editar'))
                                            <a href="{{ route('almacenes.edit', $almacen['id']) }}" title="Editar"
                                                class="btn btn-sm btn-primary mr-1"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(auth()->user()->hasPermission('almacenes.eliminar'))
                                            <form id="formDeleteAlmacen_{{ $almacen['id'] }}"
                                                action="{{route('almacenes.delete', $almacen['id']) }}" method="post">
                                                @csrf
                                                <button type="button" title="Eliminar"
                                                    onclick="confirmDelete({{ $almacen['id'] }})" title="Eliminar"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @endif
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
                    var formId = 'formDeleteAlmacen_' + id;
                    var form = document.getElementById(formId);
                    form.submit(); // Envía el formulario si el usuario confirma
                }
            });
        }
    </script>
    @endpush

</x-layouts.app>
