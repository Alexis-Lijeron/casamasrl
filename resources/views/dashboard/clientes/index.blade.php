<x-layouts.app>

    <x-layouts.content title="Clientes" subtitle="" name="Clientes">

        <div class="row">
            <div class="col-12">

                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        @if(auth()->user()->hasPermission('clientes.crear'))
                        <a href="{{ route('clientes.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nuevo Cliente
                        </a>
                        @endif
                    </div>
                </div>

                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-clientes" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Género</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                <tr class="text-nowrap text-center">
                                    <th scope="row" class="align-middle">{{ $cliente['id'] }}</th>
                                    <td class="align-middle">{{ $cliente['nombre'] }}</td>
                                    <td class="align-middle">{{ $cliente['apellido'] }}</td>
                                    <td class="align-middle">{{ $cliente['telefono'] ?? '-- Ninguno --' }}</td>
                                    <td class="align-middle">{{ $cliente['email'] ?? '-- Ninguno --' }}</td>
                                    <td class="align-middle">{{ $cliente['genero'] }}</td>
                                    <td class="align-middle text-nowrap">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('clientes.show', $cliente['id']) }}" title="Ver" class="btn btn-sm btn-warning">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(auth()->user()->hasPermission('clientes.editar'))
                                            <a href="{{ route('clientes.edit', $cliente['id']) }}" title="Editar"  class="btn btn-sm btn-primary mx-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif
                                            @if(auth()->user()->hasPermission('clientes.eliminar'))
                                            <form id="formDeleteCliente_{{ $cliente['id'] }}" action="{{route('clientes.delete', $cliente['id']) }}" method="post">
                                                @csrf
                                                <button type="button" title="Eliminar"
                                                onclick="confirmDelete({{ $cliente['id'] }})" title="Eliminar" class="btn btn-sm btn-danger">
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
                        var formId = 'formDeleteCliente_' + id;
                        var form = document.getElementById(formId);
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            }
        </script>
    @endpush

</x-layouts.app>
