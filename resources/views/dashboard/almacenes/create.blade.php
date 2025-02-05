<x-layouts.app>

    <x-layouts.content title="Almacenes" subtitle="Crear almacén" name="Almacenes">

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-plus-circle fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Crear nuevo almacén</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{ route('almacenes.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Introduzca el nombre del almacén" value="{{ old('nombre') }}">
                                    @error('nombre')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion"
                                        placeholder="Introduzca la descripción" rows="3">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group m-b-0">
                                    <a href="{{ route('almacenes.index') }}" class="btn btn-danger waves-effect m-l-5">
                                        Cancelar
                                    </a>
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        Guardar
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6 bg-light rounded p-3">
                                <div class="form-row align-items-end">
                                    <div class="form-group col-md-6">
                                        <label for="producto_id">Producto</label>
                                        <select id="producto_id" class="form-control select2">
                                            <option value="">Seleccione un producto</option>
                                            @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}">
                                                {{ $producto->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                                        <input type="date" id="fecha_vencimiento" class="form-control">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <button type="button" class="btn btn-success btn-block mt-4"
                                            id="agregar-producto">Agregar
                                        </button>
                                    </div>
                                </div>

                                <div class="form-row align-items-end">
                                    <div class="form-group col-md-12">
                                        <label class="mb-2">Productos agregados</label>
                                        <table class="table table-bordered">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th class="text-center">Producto</th>
                                                    <th class="text-center">Fecha de Vencimiento</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="productos-table-body">
                                                <tr id="mensaje-vacio" class="text-center">
                                                    <td colspan="3">No hay productos agregados.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" name="productos" id="productos-input">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </x-layouts.content>

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productos = [];
            const productoSelect = document.getElementById('producto_id');
            const fechaInput = document.getElementById('fecha_vencimiento');
            const productosTableBody = document.getElementById('productos-table-body');
            const productosInput = document.getElementById('productos-input');
            const mensajeVacio = document.getElementById('mensaje-vacio');

            document.getElementById('agregar-producto').addEventListener('click', function() {
                const productoId = productoSelect.value;
                const productoNombre = productoSelect.options[productoSelect.selectedIndex]?.text;
                const fechaVencimiento = fechaInput.value;

                if (!productoId) {
                    mostrarAlerta('Oops!', 'Seleccione un producto.', 'info');
                    return;
                }

                if (!fechaVencimiento) {
                    mostrarAlerta('Oops!', 'Seleccione una fecha de vencimiento.', 'info');
                    return;
                }

                if (productos.some(producto => producto.productoId === productoId)) {
                    mostrarAlerta('Oops!', 'El producto ya está agregado.', 'info');
                    return;
                }

                productos.push({
                    productoId,
                    productoNombre,
                    fechaVencimiento
                });

                renderTable();

                productoSelect.value = '';
                fechaInput.value = '';
            });

            function renderTable() {
                productosTableBody.innerHTML = '';
                productos.forEach((producto, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="align-middle text-center">${producto.productoNombre}</td>
                        <td class="align-middle text-center">${producto.fechaVencimiento}</td>
                        <td class="align-middle text-center">
                            <button type="button" class="btn btn-danger btn-sm" data-index="${index}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    `;
                    productosTableBody.appendChild(row);
                });

                if (productos.length === 0) {
                    productosTableBody.appendChild(mensajeVacio);
                }

                productosInput.value = JSON.stringify(productos);

                const deleteButtons = productosTableBody.querySelectorAll('.btn-danger');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const index = this.dataset.index;
                        eliminarProducto(index);
                    });
                });
            }

            function eliminarProducto(index) {
                productos.splice(index, 1);
                renderTable();
            }

            function mostrarAlerta(titulo, mensaje, tipo, tiempo = 3000) {
                Swal.fire({
                    title: titulo,
                    text: mensaje,
                    icon: tipo,
                    timer: tiempo
                });
            }
        });
    </script>
    @endpush

</x-layouts.app>