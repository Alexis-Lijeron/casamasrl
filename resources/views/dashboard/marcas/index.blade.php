<x-layouts.app>

    <x-layouts.content title="Marcas" subtitle="" name="Marcas">

        <div class="row">
            <div class="col-12">
                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        @if(auth()->user()->hasPermission('marcas.crear'))
                        <a href="{{ route('marcas.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nueva Marca
                        </a>
                        @endif
                    </div>
                </div>

                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-marca" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marcas as $marca)
                                <tr class="text-nowrap text-center">
                                    <th scope="row" class="align-middle">{{ $marca['id'] }}</th>
                                    <td class="align-middle">{{ $marca['nombre'] }}</td>
                                    <td class="align-middle text-nowrap">
                                        <div class="d-flex justify-content-center">
                                            @if(auth()->user()->hasPermission('marcas.editar'))
                                            <a href="{{ route('marcas.edit', $marca['id']) }}" title="Editar"
                                            class="btn btn-sm btn-primary mx-1"><i class="fas fa-edit"></i></a>@endif
                                            @if(auth()->user()->hasPermission('marcas.eliminar'))
                                            <form id="formDeleteMarca_{{ $marca['id'] }}"
                                            action="{{route('marcas.delete', $marca['id']) }}" method="post">
                                                @csrf
                                                <button type="button" title="Eliminar"
                                                onclick="confirmDelete({{ $marca['id'] }})" title="Eliminar" class="btn btn-sm btn-danger">
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
                        var formId = 'formDeleteMarca_' + id;
                        var form = document.getElementById(formId);
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            }
        </script>
    @endpush

</x-layouts.app>
