<x-layouts.app>

    <x-layouts.content title="Usuarios" subtitle="" name="Usuarios">

        <div class="row">
            <div class="col-12">

                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        <a href="{{ route('usuarios.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nuevo Usuario
                        </a>
                    </div>
                </div>

                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-usuario" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr class="text-nowrap text-center">
                                        <th scope="row" class="align-middle">{{ $usuario['id'] }}</th>
                                        <td class="align-middle">
                                            {{ $usuario['nombre'] }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $usuario['apellido'] }}
                                            </td>
                                        <td class="align-middle">{{ $usuario['email'] }}</td>
                                        <td class="align-middle">{{ $usuario['telefono'] }}</td>
                                        <td class="align-middle">
                                            @foreach($usuario->roles as $rol)
                                                {{ $rol->nombre }}@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td class="align-middle text-nowrap" style="width: 150px">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('usuarios.show', $usuario['id']) }}" title="Ver" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('usuarios.edit', $usuario['id']) }}" title="Editar" class="btn btn-sm btn-primary mx-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form id="formDeleteUsuario_{{ $usuario['id'] }}" action="{{route('usuarios.delete', $usuario['id']) }}" method="post">
                                                    @csrf
                                                    <button type="button" title="Eliminar"
                                                    onclick="confirmDelete({{ $usuario['id'] }})" title="Eliminar" class="btn btn-sm btn-danger">
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
                        var formId = 'formDeleteUsuario_' + id;
                        var form = document.getElementById(formId);
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            }
        </script>
    @endpush

</x-layouts.app>
