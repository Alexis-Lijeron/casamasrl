<x-layouts.app>

    <x-layouts.content title="Ajuste Inventario" subtitle="Editar Ajuste Inventario" name="Ajuste Inventario">

        <div class="row mb-5">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-pencil-alt fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Ajuste Inventario</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{ route('ajustes.update', $ajuste['id']) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" style="background: white;" id="fecha"
                                        class="form-control" value="{{ old('fecha', formatoSinHora($ajuste['fecha'])) }}">
                                    @error('fecha')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tipo">Tipo</label>
                                    <select id="tipo" name="tipo" class="form-control">
                                        <option value="">Seleccione el tipo</option>
                                        <option value="Ingreso" {{ old('tipo', $ajuste['tipo']) == 'Ingreso' ? 'selected' : '' }}>Ingreso</option>
                                        <option value="Egreso" {{ old('tipo', $ajuste['tipo']) == 'Egreso' ? 'selected' : '' }}>Egreso</option>
                                    </select>
                                    @error('tipo')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="5"
                                        placeholder="Introduzca la descripción">{{ old('descripcion', $ajuste['descripcion']) }}</textarea>
                                    @error('descripcion')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <hr class="mt-3 mb-3" style="height: 1px; background-color: #B4B4B4FF;">

                        <h3 class="mb-3">Detalle del Ajuste</h3>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="almacen_id">Almacen</label>
                                    <select id="almacen_id" class="form-control" style="width: 100%;"
                                        data-toggle="select2">
                                        <option value="">Seleccione un almacen</option>
                                        @foreach ($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}">
                                            {{ $almacen->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="producto_id">Producto</label>
                                    <select id="producto_id" class="form-control" style="width: 100%;"
                                        data-toggle="select2" disabled>
                                        <option value="">Seleccione un producto</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="number" id="cantidad" class="form-control" value="1">
                                </div>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <button type="button" class="btn btn-success btn-block w-100"
                                        id="agregar-producto">Agregar</button>
                                </div>
                            </div>

                        </div>
                        @error('productos')
                        <span class="error text-danger">* {{ $message }}</span>
                        @enderror

                        <div class="form-row align-items-end mt-2">
                            <!-- Tabla de Productos Agregados -->
                            <div class="form-group col-lg-12">
                                <h3 class="mb-3">Productos Agregados</h3>
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white ">
                                        <tr>
                                            <th class="text-center">ID producto</th>
                                            <th class="text-center">Producto</th>
                                            <th class="text-center">Almacen</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productos-table-body">
                                        <tr id="mensaje-vacio" class="text-center">
                                            <td colspan="5">No hay productos agregados.</td>
                                        </tr>
                                        <!-- Los productos se irán agregando aquí -->
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="form-group text-right m-b-0">
                            <a href="{{ route('ajustes.index') }}" class="btn btn-danger waves-effect m-l-5">
                                Cancelar
                            </a>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                Actualizar
                            </button>
                        </div>

                        <input type="hidden" name="productos" id="productos-input">
                    </form>

                </div>
            </div>
        </div>

    </x-layouts.content>

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productos = []; // Array para almacenar productos seleccionados
            const productoSelect = document.getElementById('producto_id');
            const almacenSelect = document.getElementById('almacen_id');
            const cantidadInput = document.getElementById('cantidad');
            const productosTableBody = document.getElementById('productos-table-body');
            const productosInput = document.getElementById('productos-input');
            const totalInput = document.getElementById('total');
            const mensajeVacio = document.getElementById('mensaje-vacio');


            // Recuperar los productos de la sesión o del detalle
            @if(session('productos'))
            // Si hay datos en la sesión, cargarlos
            const productosSession = @json(json_decode(session('productos'), true));
            @else
            // Si no hay datos en la sesión, cargar los datos del detalle
            const productosSession = @json($detalle);
            @endif


            // Llenar el array de productos con los datos de la sesión
            productosSession.forEach(producto => {
                productos.push(producto);
            });

            // Renderizar la tabla con los productos recuperados
            renderTable();

            $('#almacen_id').on('change', function() {
                const selectedValue = $(this).val();
                const selectedOption = $(this).find(`option[value="${selectedValue}"]`);
                const almacenId = selectedValue;

                productoSelect.innerHTML = '<option value="">Cargando...</option>';
                productoSelect.disabled = true;

                // Verificar que el almacen seleccionado no esté vacío
                if (almacenId && almacenId.trim() !== "") {
                    const url = "{{ route('compras.obtenerProductosPorAlmacen', ':almacenId') }}".replace(':almacenId', almacenId);
                    fetch(url)
                        .then(response => response.json())
                        .then(productos => {
                            productoSelect.innerHTML = '<option value="">Seleccione un producto</option>';
                            productos.forEach(producto => {
                                const option = document.createElement('option');
                                option.value = producto.producto_id;
                                option.textContent = producto.producto_nombre;

                                // asignar los atributos data al option
                                option.dataset.productoAlmacenId = producto.id;

                                productoSelect.appendChild(option);
                            });
                            productoSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error al cargar los productos:', error);
                            productoSelect.innerHTML = '<option value="">Error al cargar productos</option>';
                        });
                } else {
                    productoSelect.innerHTML = '<option value="">Seleccione un producto</option>';
                }

            });

            $('#producto_id').on('change', function() {
                const selectedValue = $(this).val();
                const selectedOption = $(this).find(`option[value="${selectedValue}"]`);
            });

            // Agregar producto al array y mostrar en la tabla
            document.getElementById('agregar-producto').addEventListener('click', function() {
                const productoId = productoSelect.value;
                const almacenNombre = almacenSelect.options[almacenSelect.selectedIndex].text;
                const almacenId = almacenSelect.value;
                const productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
                const productoAlmacenId = productoSelect.options[productoSelect.selectedIndex].dataset.productoAlmacenId;
                const cantidad = parseInt(cantidadInput.value, 10);

                if (!productoId) {
                    mostrarAlerta('Oops!', 'Seleccione un producto válido.', 'info');
                    return;
                }

                // Verificar si el producto ya está agregado al mismo almacén
                if (productos.some(producto => producto.productoId === productoId && producto.almacenNombre === almacenNombre)) {
                    mostrarAlerta('Oops!', 'El producto ya está agregado en este almacén.', 'info');
                    return;
                }

                // Agregar al array de productos
                productos.push({
                    productoId,
                    productoNombre,
                    almacenNombre,
                    cantidad,
                    productoAlmacenId
                });

                // Actualizar tabla
                renderTable();

                // Limpiar los campos
                cantidadInput.value = 1;

                // Actualizar Select2
                $(productoSelect).val('').trigger('change');
            });

            // Renderizar la tabla con los productos actuales
            function renderTable() {
                productosTableBody.innerHTML = '';
                productos.forEach((producto, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="align-middle text-center">${producto.productoId}</td>
                        <td class="align-middle text-center">${producto.productoNombre}</td>
                        <td class="align-middle text-center">${producto.almacenNombre}</td>
                        <td>
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-sm btn-outline-danger me-2" onclick="disminuirCantidad(${index})">-</button>
                            <span class="mx-3">${producto.cantidad}</span>
                            <button type="button" class="btn btn-sm btn-outline-success ms-2" onclick="aumentarCantidad(${index})">+</button>
                        </div>
                        </td>
                        <td class="align-middle text-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    `;
                    productosTableBody.appendChild(row);
                });

                if (productos.length === 0) {
                    productosTableBody.appendChild(mensajeVacio);
                }

                // Actualizar el input oculto para enviar los datos al backend
                productosInput.value = JSON.stringify(productos);
            }

            // Función para aumentar la cantidad
            window.aumentarCantidad = function(index) {
                productos[index].cantidad++;
                productos[index].subtotal = productos[index].cantidad * productos[index].precioCompra;
                renderTable();
            };

            // Función para disminuir la cantidad
            window.disminuirCantidad = function(index) {
                // if (productos[index].cantidad > 1) {
                productos[index].cantidad--;
                productos[index].subtotal = productos[index].cantidad * productos[index].precioCompra;
                renderTable();
                // }
            };

            // Función para eliminar un producto
            window.eliminarProducto = function(index) {
                productos.splice(index, 1);
                renderTable();
            };


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