<x-layouts.app>

    <x-layouts.content title="Almacenes" subtitle="Editar almacen" name="Almacenes">

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-pencil-alt fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Editar almacen</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{ route('almacenes.update', $almacen['id']) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Introduzca el nombre del almacen" value="{{ old('nombre', $almacen['nombre']) }}" >
                                    @error('nombre')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion"
                                        placeholder="Introduzca la descripción"
                                        rows="3">{{ old('descripcion', $almacen['descripcion']) }}</textarea>
                                    @error('descripcion')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group m-b-0">
                                    <a href="{{ route('almacenes.index') }}" class="btn btn-danger waves-effect m-l-5">
                                        Cancelar
                                    </a>
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        Actualizar
                                    </button>
                                </div>
                            </div>
                            
                            <div class="col-md-6 bg-light rounded p-3">
                                <div class="form-row align-items-end">
                                    <div class="form-group col-md-9">
                                        <label for="producto_id">Producto</label>
                                        <select id="producto_id" class="form-control" style="width: 100%;"
                                            data-toggle="select2">
                                            <option value="">Seleccione un producto</option>
                                            @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}"
                                                data-precio="{{ $producto->precio }}">
                                                {{ $producto->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="button" class="btn btn-success btn-block"
                                            id="agregar-producto">Agregar
                                        </button>
                                    </div>
                                </div>

                                <div class="form-row align-items-end">
                                    <!-- Tabla de Productos Agregados -->
                                    <div class="form-group col-md-12">
                                        <label class="mb-2">Productos agregados</label>
                                        <table class="table table-bordered">
                                            <thead class="bg-dark text-white ">
                                                <tr>
                                                    <th class="text-center">Producto</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="productos-table-body">
                                                <tr id="mensaje-vacio" class="text-center">
                                                    <td colspan="5">No hay productos agregados.</td>
                                                </tr>
                                                <!-- Los productos se irán agregando aquí -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Productos ocultos para enviar al backend -->
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
        document.addEventListener('DOMContentLoaded', function () {
            const productos = []; // Array para almacenar productos seleccionados
            const productoSelect = document.getElementById('producto_id');
            const productosTableBody = document.getElementById('productos-table-body');
            const productosInput = document.getElementById('productos-input');
            const mensajeVacio = document.getElementById('mensaje-vacio');
            
            const productosAsociados = @json($almacen->productos);
        
            // Cargar los datos en la variable productos
            productosAsociados.forEach(producto => {
                const productoId = producto.id;
                const productoNombre = producto.nombre;

                // Agregar objeto al array productos
                productos.push({ productoId, productoNombre });
            });
            
            // Renderizar la tabla con los productos actuales
            renderTable();
    
            $('#producto_id').on('change', function () {
                const selectedValue = $(this).val();
                const selectedOption = $(this).find(`option[value="${selectedValue}"]`);
            });
  
            // Agregar producto al array y mostrar en la tabla
            document.getElementById('agregar-producto').addEventListener('click', function () {
                const productoId = productoSelect.value;
                const productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
    
                if (!productoId) {
                    mostrarAlerta('Oops!', 'Seleccione un producto.', 'info');
                    return;
                }
                
                if (productos.some(producto => producto.productoId === productoId)) {
                    mostrarAlerta('Oops!', 'El producto ya está agregado.', 'info');
                    return;
                }
    
                // Agregar al array de productos
                productos.push({ productoId, productoNombre });
    
                // Actualizar tabla
                renderTable();
    
                // Limpiar los campos
                $(productoSelect).val('').trigger('change');
            });
    
            // Renderizar la tabla con los productos actuales
            function renderTable() {
                productosTableBody.innerHTML = '';
                productos.forEach((producto, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="align-middle text-center">${producto.productoNombre}</td>
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
    
            // Función para eliminar un producto
            window.eliminarProducto = function (index) {
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
