<x-layouts.app>

    <x-layouts.content title="Reportes" subtitle="Reporte de Compras" name="Reporte Compras">

        <div class="row">
            <div class="col-12">

                <div class="card-box">

                    <div class="row justify-content-center font-weight-bold font-22 mb-2">
                        Reportes de Compras</div>

                    <hr style="background: rgb(237, 237, 237); height: 1.2px">

                    <form method="post" id="formularioReporte">
                        <div class="row">
                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="id_empleado" class="control-label mb-1 pl-1">
                                        <strong>Elige el administrativo</strong>
                                    </label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="id_empleado"
                                        name="id_empleado">
                                        <option value="0">Todos</option>
                                        @foreach ($usuarios as $administrativo)
                                        <option value="{{ $administrativo['id'] }}"
                                            @if ($administrativo['id']==old('id_empleado')) selected @endif>
                                            {{ $administrativo['nombre'] }} {{ $administrativo['apellido'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeAdministrativo" class="error text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="id_proveedor" class="control-label mb-1 pl-1"><strong>Elige el proveedor</strong></label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="id_proveedor"
                                        name="id_proveedor">
                                        <option value="0">Todos</option>
                                        @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor['id'] }}"
                                            @if ($proveedor['id']==old('id_proveedor')) selected @endif>
                                            {{ $proveedor['nombre_empreesa'] }} - {{ $proveedor['nombre_proveedor'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeCliente" class="error text-danger"></span>
                                </div>
                            </div>

                            {{-- <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="estado" class="control-label mb-1 pl-1"><strong>Elige el estado</strong></label>
                                    <select class="form-control text-truncate" name="estado" id="estado">
                                        <option value="0">Todos</option>
                                        <option value="Ingresado">Ingresado</option>
                                        <option value="En proceso">En proceso</option>
                                        <option value="Esperando repuesto">Esperando repuesto</option>
                                        <option value="Reparado">Reparado</option>
                                        <option value="Entregado">Entregado</option>
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="id_producto" class="control-label mb-1 pl-1">
                                        <strong>Elige el producto</strong>
                                    </label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="id_producto"
                                        name="id_producto">
                                        <option value="0">Todos</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto['id'] }}"
                                            @if ($producto['id']==old('id_producto')) selected @endif>{{
                                            $producto['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeProducto" class="error text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3 px-1">
                                <label for="fechaDesde" class="control-label mb-1 pl-1">
                                    <strong>Fecha desde</strong>
                                </label>
                                <div class="input-group">
                                    <input type="text" id="fechaDesde" name="fechaDesde"
                                        placeholder="dd/mm/aaaa" class="form-control flatpickr"
                                        value="{{ old('fechaDesde') }}"
                                        style="background: transparent;" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                                <span id="mensajeFechaDesde" class="error text-danger"></span>
                            </div>

                            <div class="col-md-3 px-1">
                                <label for="fechaHasta" class="control-label mb-1 pl-1">
                                    <strong>Fecha hasta</strong>
                                </label>
                                <div class="input-group">
                                    <input type="text" id="fechaHasta" name="fechaHasta"
                                        placeholder="dd/mm/aaaa" class="form-control flatpickr"
                                        value="{{ old('fechaHasta') }}"
                                        style="background: transparent;" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                                <span id="mensajeFechaHasta" class="error text-danger"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 px-1 pt-2">
                                <div class="form-group mb-1">
                                    <button type="subtmit" id="btnConsultar"
                                        class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2">
                                        <i class="fas fa-check-square mr-2 font-20"></i>
                                        Consultar
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 px-1 pt-2">
                                <div class="form-group mb-1">
                                    <button type="submit" id="btnPdf" class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2" disabled>
                                        <i class="fas fa-file-pdf mr-2 font-20"></i>
                                        Generar PDF
                                    </button>
                                </div>
                            </div>

                            {{-- <div class="col-md-3 px-1 pt-2">
                                <div class="form-group mb-1">
                                    <a href="{{ route('generar.excel') }}" class="btn btn-dark waves-effect m-l-5 w-100 d-flex align-items-center justify-content-center py-2">
                            <i class="fas fa-file-pdf mr-2 font-20"></i>
                            Generar Excel
                            </a>
                        </div>
                </div> --}}

            </div>

            <hr id="dividerDatos" style="display: none; background: rgb(237, 237, 237); height: 1.2px">

            <div class="row mx-4 mt-4" id="loadingIndicator" style="display: none">
                <div class='container'>
                    <div class='loader'>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--text'></div>
                    </div>
                </div>
            </div>
            </form>

            <div class="table-responsive" id="datos" style="display: none;">
                <table id="table-ordenes" class="table table-bordered table-hover mb-0">
                    <thead class="bg-dark text-center text-white text-nowrap">
                        <tr style="cursor: pointer">
                            <th scope="col" style="width: 60px;">ID</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Fecha Ingreso</th>
                            <th scope="col">Fecha Salida</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Administrativo</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
        </div>
        </div>

    </x-layouts.content>

    @push('styles')
    <style>
        .container {
            height: 120px;
            width: 100%;
        }

        .loader {
            height: 20px;
            width: 250px;
            position: relative;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        .loader--dot {
            animation-name: loader;
            animation-timing-function: ease-in-out;
            animation-duration: 3s;
            animation-iteration-count: infinite;
            height: 20px;
            width: 20px;
            border-radius: 100%;
            background-color: black;
            position: absolute;
            border: 2px solid white;
        }

        .loader--dot:first-child {
            background-color: #8cc759;
            animation-delay: 0.5s;
        }

        .loader--dot:nth-child(2) {
            background-color: #8c6daf;
            animation-delay: 0.4s;
        }

        .loader--dot:nth-child(3) {
            background-color: #ef5d74;
            animation-delay: 0.3s;
        }

        .loader--dot:nth-child(4) {
            background-color: #f9a74b;
            animation-delay: 0.2s;
        }

        .loader--dot:nth-child(5) {
            background-color: #60beeb;
            animation-delay: 0.1s;
        }

        .loader--dot:nth-child(6) {
            background-color: #fbef5a;
            animation-delay: 0s;
        }

        .loader--text {
            position: absolute;
            top: 200%;
            left: 0;
            right: 0;
            width: 4rem;
            margin: auto;
        }

        .loader--text:after {
            content: "Cargando";
            font-weight: bold;
            animation-name: loading-text;
            animation-duration: 3s;
            animation-iteration-count: infinite;
        }

        @keyframes loader {
            15% {
                transform: translateX(0);
            }

            45% {
                transform: translateX(230px);
            }

            65% {
                transform: translateX(230px);
            }

            95% {
                transform: translateX(0);
            }
        }

        @keyframes loading-text {
            0% {
                content: "Cargando";
            }

            25% {
                content: "Cargando.";
            }

            50% {
                content: "Cargando..";
            }

            75% {
                content: "Cargando...";
            }
        }
    </style>
    @endpush

    @push('js')
    <script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaDesde = document.getElementById('fechaDesde');
            const fechaHasta = document.getElementById('fechaHasta');
            const administrativo = document.getElementById('id_empleado');
            const proveedor = document.getElementById('id_proveedor');
            const mecanico = document.getElementById('id_mecanico');
            const servicio = document.getElementById('id_servicio');
            const producto = document.getElementById('id_producto');
            const btnConsultar = document.getElementById('btnConsultar');
            const btnPdf = document.getElementById('btnPdf');
            const tableOrdenesBody = document.querySelector('#table-ordenes tbody');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const datosDiv = document.getElementById('datos');
            const dividerDatos = document.getElementById('dividerDatos');

            ocultarMensaje();

            // Manejar el clic en el botón "Consultar"
            btnConsultar.addEventListener('click', function(event) {
                event.preventDefault();

                if (validarDatos()) {
                    datosDiv.style.display = 'none';
                    dividerDatos.style.display = 'none';
                    btnPdf.disabled = true;
                    loadingIndicator.style.display = 'block';

                    const data = {
                        id_empleado: administrativo.value || null,
                        id_proveedor: proveedor.value || null,
                        id_mecanico: mecanico.value || null,
                        id_servicio: servicio.value || null,
                        id_producto: producto.value || null,
                        estado: document.getElementById('estado').value || null,
                        fechaDesde: fechaDesde.value ? convertirFecha(fechaDesde.value) : null,
                        fechaHasta: fechaHasta.value ? convertirFecha(fechaHasta.value) : null,
                    };

                    const urlApi = "{{ env('URL_SERVER_API') }}";
                    const url = `${urlApi}/reportes-orden-trabajos`;

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data),
                        })
                        .then(response => response.json())
                        .then(data => {
                            dividerDatos.style.display = 'block';
                            datosDiv.style.display = 'block';
                            loadingIndicator.style.display = 'none';
                            verificarCampos();

                            tableOrdenesBody.innerHTML = '';

                            if (data.ordenes.length > 0) {
                                data.ordenes.forEach(orden => {
                                    const row = `
                                    <tr class="text-nowrap text-center">
                                        <th scope="row" class="align-middle">${orden.id}</th>
                                        <td class="align-middle">${orden.fecha_creacion}</td>
                                        <td class="align-middle">${orden.fecha_inicio}</td>
                                        <td class="align-middle">${orden.fecha_fin}</td>
                                        <td class="align-middle">${orden.cotizacion.proveedor.nombre} ${orden.cotizacion.proveedor.apellido}</td>
                                        <td class="align-middle">${orden.cotizacion.empleado.nombre} ${orden.cotizacion.empleado.apellido}</td>
                                        <td class="align-middle">${orden.estado}</td>
                                    </tr>`;
                                    tableOrdenesBody.insertAdjacentHTML('beforeend', row);
                                });
                            } else {
                                const noResultsRow = `
                                <tr class="text-nowrap text-center">
                                    <td colspan="7" class="align-middle">No hay registros</td>
                                </tr>`;
                                tableOrdenesBody.insertAdjacentHTML('beforeend', noResultsRow);
                            }
                        })
                        .catch(error => {
                            console.error('Error en la petición fetch:', error);
                        });
                }
            });

            // Manejar el clic en el botón "Generar PDF"
            btnPdf.addEventListener('click', function(event) {
                event.preventDefault();
                generarPDF();
            });

            function generarPDF() {
                const url = `/dashboard/generar-reporte-ordenes/pdf/${administrativo.value || 'null'}/${proveedor.value || 'null'}/${mecanico.value || 'null'}/${document.getElementById('estado').value || 'null'}/${servicio.value || 'null'}/${producto.value || 'null'}/${fechaDesde.value ? convertirFecha(fechaDesde.value) : 'null'}/${fechaHasta.value ? convertirFecha(fechaHasta.value) : 'null'}`;
                window.open(url, '_blank');
            }

            function validarDatos() {
                let valid = true;

                if (!fechaDesde.value && !fechaHasta.value && !administrativo.value && !proveedor.value && !mecanico.value && !servicio.value && !producto.value) {
                    mostrarErrores();
                    valid = false;
                }
                return valid;
            }

            function mostrarErrores() {
                if (!fechaDesde.value) document.getElementById('mensajeFechaDesde').textContent = "El campo fecha desde es requerido.";
                if (!fechaHasta.value) document.getElementById('mensajeFechaHasta').textContent = "El campo fecha hasta es requerido.";
                if (!administrativo.value) document.getElementById('mensajeAdministrativo').textContent = "El campo administrativo es requerido.";
                if (!proveedor.value) document.getElementById('mensajeCliente').textContent = "El campo proveedor es requerido.";
                if (!mecanico.value) document.getElementById('mensajeMecanico').textContent = "El campo mecánico es requerido.";
                if (!servicio.value) document.getElementById('mensajeServicio').textContent = "El campo servicio es requerido.";
                if (!producto.value) document.getElementById('mensajeProducto').textContent = "El campo producto es requerido.";
            }

            function verificarCampos() {
                if (fechaDesde.value && fechaHasta.value && administrativo.value && proveedor.value && mecanico.value && servicio.value && producto.value) {
                    btnPdf.disabled = false;
                } else {
                    btnPdf.disabled = true;
                }
            }

            function ocultarMensaje() {
                const fields = [fechaDesde, fechaHasta, administrativo, proveedor, mecanico, servicio, producto];
                fields.forEach(field => {
                    field.addEventListener('change', function() {
                        const messageId = `mensaje${field.id.charAt(0).toUpperCase() + field.id.slice(1)}`;
                        document.getElementById(messageId).textContent = '';
                    });
                });
            }

            function convertirFecha(fecha) {
                const partes = fecha.split('/');
                return `${partes[2]}-${partes[1]}-${partes[0]}`;
            }

            flatpickr('.flatpickr', {
                enableTime: false,
                dateFormat: 'd/m/Y',
                locale: {
                    firstDayofWeek: 1,
                    weekdays: {
                        shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                        longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                    },
                    months: {
                        shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                        longhand: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    },
                },
            });
        });
    </script>
    @endpush

</x-layouts.app>