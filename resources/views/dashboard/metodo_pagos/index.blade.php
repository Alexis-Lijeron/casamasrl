<x-layouts.app>

    <x-layouts.content title="Metodos de Pago" subtitle="" name="Metodos de Pago">

        <div class="row">
            <div class="col-12">
                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        <a href="{{ route('metodos-pago.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nuevo Metodo de Pago
                        </a>
                    </div>
                </div>

                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-metodo" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($metodos_pagos as $metodo)
                                <tr class="text-nowrap text-center">
                                    <th scope="row" class="align-middle">{{ $metodo['id'] }}</th>
                                    <td class="align-middle">{{ $metodo['nombre'] }}</td>
                                    <td class="align-middle text-nowrap">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('metodos-pago.edit', $metodo['id']) }}" title="Editar"
                                            class="btn btn-sm btn-primary mx-1"><i class="fas fa-edit"></i></a>
                                            <form id="formDeleteMetodo_{{ $metodo['id'] }}"
                                            action="{{route('metodos-pago.delete', $metodo['id']) }}" method="post">
                                                @csrf
                                                <button type="button" title="Eliminar"
                                                onclick="confirmDelete({{ $metodo['id'] }})" title="Eliminar" class="btn btn-sm btn-danger">
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
                        var formId = 'formDeleteMetodo_' + id;
                        var form = document.getElementById(formId);
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            }
        </script>
    @endpush

</x-layouts.app>
