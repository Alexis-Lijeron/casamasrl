<x-layouts.app>

    <x-layouts.content title="Productos" subtitle="" name="Productos">

        <div class="row">
            <div class="col-12">

                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        <a href="{{ route('productos.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nuevo Producto
                        </a>
                    </div>
                </div>

                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-productos" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Stock Mínimo</th>
                                    <th scope="col">Stock Disponible</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Marca</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                <tr class="text-center">
                                    <th scope="row" class="align-middle">{{ $producto['id'] }}</th>
                                    <td class="align-middle">
                                        <img src="{{ $producto['url_imagen'] }}" alt="{{ $producto['nombre'] }}" style="width: 70px; height: 70px;">
                                    </td>
                                    <td class="align-middle">{{ $producto['nombre'] }}</td>
                                    <td class="align-middle">
                                        {{ $producto['stock_minimo'] }} unidades
                                    </td>
                                    <td class="align-middle">
                                        @if (obtenerStockDisponible($producto['id']) <= $producto['stock_minimo'])
                                            <span class="text-danger py-1 px-2 rounded-lg d-inline-block"
                                            style="background-color: #f8d7da;">{{ obtenerStockDisponible($producto['id']) }} unidades</span>
                                        @else
                                            <span class="text-success py-1 px-2 rounded-lg d-inline-block"
                                            style="background-color: #d4edda;">{{ obtenerStockDisponible($producto['id']) }} unidades</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">Bs. {{ $producto['precio_venta'] }}</td>
                                    <td class="align-middle">{{ $producto['categoria']['nombre'] }}</td>
                                    <td class="align-middle">{{ $producto['marca']['nombre'] }}</td>
                                    <td class="align-middle text-nowrap">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('productos.show', $producto['id']) }}" title="Ver" class="btn btn-sm btn-warning">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('productos.edit', $producto['id']) }}" title="Editar"  class="btn btn-sm btn-primary mx-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="formDeleteProducto_{{ $producto['id'] }}" action="{{route('productos.delete', $producto['id']) }}" method="post">
                                                @csrf
                                                <button type="button" title="Eliminar"
                                                onclick="confirmDelete({{ $producto['id'] }})" title="Eliminar" class="btn btn-sm btn-danger">
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
                        var formId = 'formDeleteProducto_' + id;
                        var form = document.getElementById(formId);
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            }
        </script>
    @endpush

</x-layouts.app>
