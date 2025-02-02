<x-layouts.app>

    <x-layouts.content title="Reportes" subtitle="Reporte de Compras" name="Reporte de Compras">

        <div class="row mb-5">
            <div class="col-12">

                <div class="card-box">

                    <div class="row justify-content-center font-weight-bold font-22 mb-2">
                        Reportes de Compras</div>

                    <hr style="background: rgb(237, 237, 237); height: 1.2px">

                    <form id="formularioReporte" action="{{ route('reportes.mostrarVentasResultados') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="usuario" class="control-label mb-1 pl-1">
                                        <strong>Elige el usuario</strong>
                                    </label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="usuario"
                                        name="usuario">
                                        <option value="0">Todos</option>
                                        @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" {{ old('usuario')==$usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->nombre }} {{ $usuario->apellido }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeAdministrativo" class="error text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="proveedor" class="control-label mb-1 pl-1"><strong>Elige el proveedor</strong></label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="proveedor"
                                        name="proveedor">
                                        <option value="0">Todos</option>
                                        @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}" {{ old('proveedor')==$proveedor->id ? 'selected' : ''
                                            }}>
                                            {{ $proveedor->nombre_empresa }} - {{ $proveedor->nombre_encargado }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeCliente" class="error text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="producto" class="control-label mb-1 pl-1"><strong>Elige el Producto</strong></label>
                                    <select name="producto" id="producto" class="form-control text-truncate" data-toggle="select2">
                                        <option value="0">Todos</option>
                                        @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" {{ old('producto')==$producto->id ? 'selected' :
                                            '' }}>
                                            {{ $producto->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="categoria" class="control-label mb-1 pl-1"><strong>Elige la Categoría</strong></label>
                                    <select name="categoria" id="categoria" class="form-control text-truncate" data-toggle="select2">
                                        <option value="0">Todos</option>
                                        @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria')==$categoria->id ?
                                            'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <label for="fecha_desde" class="control-label mb-1 pl-1"><strong>Fecha Desde</strong></label>
                                <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                                    value="{{ old('fecha_desde') }}" required>
                                @error('fecha_desde')
                                <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3 px-1">
                                <label for="fecha_hasta" class="control-label mb-1 pl-1"><strong>Fecha Hasta</strong></label>
                                <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                                    value="{{ old('fecha_hasta') }}" required>
                                @error('fecha_hasta')
                                <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3 px-1">
                                <div class="form-group mb-1">
                                    <button type="subtmit" id="btnConsultar"
                                        class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2">
                                        <i class="fas fa-check-square mr-2 font-20"></i>
                                        Consultar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div id="tablaResultados" class="mt-3" style="display: none;">
                        <!-- Sección de la tabla, inicialmente oculta -->
                        <div class="table-responsive">
                            <table id="table-pagos" class="table table-bordered table-hover mb-0">
                                <thead class="bg-dark text-center text-white text-nowrap">
                                    <tr style="cursor: pointer">
                                        <th scope="col" style="width: 60px;">ID</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Proveedor</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Categoría</th>
                                        <th scope="col">Monto</th>
                                    </tr>
                                </thead>
                                <tbody id="ventas-table-body">
                                    <!-- Los datos de las ventas se agregarán aquí mediante JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        {{-- Envie el reporte a su correo electrónico --}}
                        <form id="formEnviarReporte" action="{{ route('reportes.email.compras') }}" method="POST">
                            @csrf
                            <button type="submit" id="btnEnviarReporte" class="btn btn-lg btn-primary mt-2">
                                Enviar por correo
                            </button>
                            <input type="hidden" name="message" id="datosReporte">
                        </form>

                    </div>


                    <!-- Mostrar en caso de no encontrar resultados -->
                    <div id="noResultados" class="mt-3" style="display: none;">
                        <table id="table-pagos" class="table table-bordered table-hover mb-0">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col" style="width: 60px;">ID</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center">No se encontraron resultados con los filtros
                                        seleccionados.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    </x-layouts.content>

    @push('js')
    <script>
        document.getElementById('formularioReporte').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir el envío normal del formulario

            var formData = new FormData(this); // Recoger los datos del formulario

            // Enviar la solicitud AJAX
            fetch("{{ route('reportes.mostrarComprasResultados') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest", // Indicar que es una solicitud AJAX
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Limpiar la tabla antes de actualizar
                    const tableBody = document.getElementById('ventas-table-body');
                    tableBody.innerHTML = '';

                    console.log(data);

                    if (data.length > 0) {
                        // Mostrar la tabla
                        document.getElementById('tablaResultados').style.display = 'block';
                        document.getElementById('noResultados').style.display = 'none';

                        // Recorrer los datos y agregar las filas a la tabla
                        data.forEach(compra => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="align-middle">${compra.id}</td>
                                <td class="align-middle">${compra.fecha_compra}</td>
                                <td class="align-middle">${compra.usuario.nombre} ${compra.usuario.apellido}</td>
                                <td class="align-middle">${compra.proveedor.nombre_empresa} ${compra.proveedor.nombre_encargado}</td>
                                <td class="align-middle">
                                    <ul>
                                        ${compra.productos_almacen.map(producto => `<li>${producto.producto.nombre}</li>`).join('')}
                                    </ul>
                                </td>
                                <td class="align-middle">
                                    <ul>
                                        ${compra.productos_almacen.map(producto => `<li>${producto.producto.categoria.nombre}</li>`).join('')}
                                    </ul>
                                </td>
                                <td class="align-middle">Bs. ${compra.monto_total}</td>
                            `;
                            tableBody.appendChild(row);
                        });

                        // Asignar el valor de message 
                        document.getElementById('datosReporte').value = JSON.stringify(data);
                    } else {
                        // Si no hay datos, mostrar el mensaje de "No se encontraron resultados"
                        document.getElementById('tablaResultados').style.display = 'none';
                        document.getElementById('noResultados').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error al realizar la solicitud:', error);
                });
        });
    </script>
    @endpush

</x-layouts.app>