<x-layouts.app>

    <x-layouts.content title="Reportes" subtitle="Reporte de Pagos" name="Reporte de Pagos">

        <div class="row mb-5">
            <div class="col-12">

                <div class="card-box">

                    <div class="row justify-content-center font-weight-bold font-22 mb-2">
                        Reportes de Pagos</div>

                    <hr style="background: rgb(237, 237, 237); height: 1.2px">

                    <form id="formularioReporte" action="{{ route('reportes.mostrarPagosResultados') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="usuario" class="control-label mb-1 pl-1">
                                        <strong>Elige el usuario</strong>
                                    </label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="usuario"
                                        name="usuario" style="width: 100%">
                                        <option value="0">Todos</option>
                                        @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" {{ old('usuario')==$usuario->id ? 'selected'
                                            : '' }}>
                                            {{ $usuario->nombre }} {{ $usuario->apellido }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeAdministrativo" class="error text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="cliente" class="control-label mb-1 pl-1"><strong>Elige el
                                            cliente</strong></label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="cliente"
                                        name="cliente" style="width: 100%">
                                        <option value="0">Todos</option>
                                        @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente')==$cliente->id ? 'selected'
                                            : ''
                                            }}>
                                            {{ $cliente->nombre }} {{ $cliente->apellido }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeCliente" class="error text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="estado" class="control-label mb-1 pl-1">
                                        <strong>Elige el estado</strong>
                                    </label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="estado"
                                        name="estado" style="width: 100%">
                                        <option value="0">Todos</option>
                                        <option value="false">Pendiente</option>
                                        <option value="true">Pagado</option>
                                    </select>
                                    <span id="mensajeEstado" class="error text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="metodo_pago" class="control-label mb-1 pl-1">
                                        <strong>Elige el metodo de pago</strong>
                                    </label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="metodo_pago"
                                        name="metodo_pago" style="width: 100%">
                                        <option value="0">Todos</option>
                                        @foreach ($metodos as $metodo)
                                        <option value="{{ $metodo->id }}" {{ old('metodo_pago')==$metodo->id ? 'selected' : '' }}>
                                            {{ $metodo->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeMetodoPago" class="error text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <label for="fecha_desde" class="control-label mb-1 pl-1"><strong>Fecha
                                        Desde</strong></label>
                                <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                                    value="{{ old('fecha_desde') }}" required>
                                @error('fecha_desde')
                                <small class="text-danger">* {{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3 px-1">
                                <label for="fecha_hasta" class="control-label mb-1 pl-1"><strong>Fecha
                                        Hasta</strong></label>
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

                    <hr id="dividerDatos" class="my-4"
                        style="display: none; background: rgb(237, 237, 237); height: 1.2px">

                    <!-- Contenedor del Spinner -->
                    <div id="loadingSpinner" style="display: none; text-align: center; margin-top: 20px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                        <p>Cargando datos...</p>
                    </div>

                    <!-- Tabla de Resultados -->
                    <div id="tablaResultados" class="mt-3" style="display: none;">
                        <!-- Sección de la tabla, inicialmente oculta -->
                        <div class="table-responsive">
                            <table id="table-pagos" class="table table-bordered table-hover mb-0">
                                <thead class="bg-dark text-center text-white text-nowrap">
                                    <tr style="cursor: pointer">
                                        <th scope="col" style="width: 60px;">ID</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Metodo Pago</th>
                                        <th scope="col">Monto</th>
                                    </tr>
                                </thead>
                                <tbody id="pagos-table-body">
                                    <!-- Los datos de las ventas se agregarán aquí mediante JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        {{-- Envie el reporte a su correo electrónico --}}
                        <form id="formEnviarReporte" action="{{ route('reportes.email.pagos') }}" method="POST">
                            @csrf
                            <button type="submit" id="btnEnviarReporte" class="btn btn-lg btn-primary mt-2">
                                Enviar por correo
                            </button>
                            <input type="hidden" name="message" id="datosReporte">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </x-layouts.content>

    @push('js')
    <script>
        document.getElementById('formularioReporte').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir el envío normal del formulario

            // Mostrar el spinner
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('tablaResultados').style.display = 'none';
            document.getElementById('dividerDatos').style.display = 'block';

            var formData = new FormData(this); // Recoger los datos del formulario

            // Enviar la solicitud AJAX
            fetch("{{ route('reportes.mostrarPagosResultados') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest", // Indicar que es una solicitud AJAX
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Ocultar el spinner
                    document.getElementById('loadingSpinner').style.display = 'none';

                    // Limpiar la tabla antes de actualizar
                    const tableBody = document.getElementById('pagos-table-body');
                    tableBody.innerHTML = '';

                    console.log(data);

                    if (data.length > 0) {
                        // Mostrar la tabla
                        document.getElementById('tablaResultados').style.display = 'block';

                        // Recorrer los datos y agregar las filas a la tabla
                        data.forEach(pago => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="align-middle">${pago.id}</td>
                                <td class="align-middle">${pago.fecha_pago}</td>
                                <td class="align-middle">${pago.nota_venta.usuario.nombre} ${pago.nota_venta.usuario.apellido}</td>
                                <td class="align-middle">${pago.nota_venta.cliente.nombre} ${pago.nota_venta.cliente.apellido}</td>
                                <td class="align-middle">${pago.estado ? 'Pagado' : 'Pendiente'}</td>
                                <td class="align-middle">${pago.metodo_pago?.nombre ?? 'No asignado'}</td>
                                <td class="align-middle">Bs. ${formatearNumero(pago.monto)}</td>
                            `;
                            tableBody.appendChild(row);
                        });

                        // Asignar el valor de message 
                        document.getElementById('datosReporte').value = JSON.stringify(data);
                    } else {
                        // Si no hay datos, mostrar el mensaje de "No se encontraron resultados"
                        document.getElementById('tablaResultados').style.display = 'block'; // Mantener el encabezado visible

                        // Agregar una fila que ocupe todas las columnas
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td colspan="7" class="text-center">No se encontraron resultados.</td>
                    `;
                        tableBody.appendChild(row);
                    }
                })
                .catch(error => {
                    console.error('Error al realizar la solicitud:', error);

                    // Ocultar el spinner en caso de error
                    document.getElementById('loadingSpinner').style.display = 'none';
                    document.getElementById('tablaResultados').style.display = 'none';
                    document.getElementById('dividerDatos').style.display = 'none';
                });
        });
    </script>
    <script>
        function formatearNumero(numero) {
            // Asegurarse de que el argumento sea un número
            numero = parseFloat(numero);

            // Verificar si es un número válido
            if (isNaN(numero)) {
                return '0,00';
            }

            // Redondear a dos decimales
            numero = numero.toFixed(2);

            // Separar los miles y los decimales
            var partes = numero.toString().split('.');
            partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Unir las partes y devolver el resultado
            return partes.join(',');
        }
    </script>
    @endpush

</x-layouts.app>