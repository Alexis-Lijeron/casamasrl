<x-layouts.app>

    <x-layouts.content title="Reportes" subtitle="Reporte de Pagos" name="Reporte de Pagos">

        <div class="row">
            <div class="col-12">

                <div class="card-box">

                    <div class="row justify-content-center font-weight-bold font-22 mb-2">
                        Reportes de Pagos</div>

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
                                    <label for="id_cliente" class="control-label mb-1 pl-1"><strong>Elige el cliente</strong></label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="id_cliente"
                                        name="id_cliente">
                                        <option value="0">Todos</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente['id'] }}"
                                            @if ($cliente['id']==old('id_cliente')) selected @endif>
                                            {{ $cliente['nombre'] }} {{ $cliente['apellido'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span id="mensajeCliente" class="error text-danger"></span>
                                </div>
                            </div>

                            {{-- <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="concepto" class="control-label mb-1 pl-1">
                                        <strong>Elige el concepto de pago</strong>
                                    </label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="concepto"
                                        name="concepto">
                                        <option value="0">Todos</option>
                                        <option value="Orden de trabajo">Orden de trabajo</option>
                                        <option value="Venta">Venta</option>
                                        <option value="Compra">Compra</option>
                                    </select>
                                    <span id="mensajeConcepto" class="error text-danger"></span>
                                </div>
                            </div> --}}

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <label for="estado" class="control-label mb-1 pl-1">
                                        <strong>Elige el estado</strong>
                                    </label>
                                    <select class="form-control text-truncate" data-toggle="select2" id="estado"
                                        name="estado">
                                        <option value="0">Todos</option>
                                        <option value="false">Pendiente</option>
                                        <option value="true">Pagado</option>
                                    </select>
                                    <span id="mensajeEstado" class="error text-danger"></span>
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
                        <table id="table-pagos" class="table table-bordered table-hover mb-0">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col" style="width: 60px;">ID</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Administrativo</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Monto</th>
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
            const cliente = document.getElementById('id_cliente');
            const estado = document.getElementById('estado');
            const concepto = document.getElementById('concepto');
            const btnConsultar = document.getElementById('btnConsultar');
            const btnPdf = document.getElementById('btnPdf');
            const tablePagosBody = document.querySelector('#table-pagos tbody');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const datosDiv = document.getElementById('datos');
            const dividerDatos = document.getElementById('dividerDatos');

            // Inicializar flatpickr
            flatpickr('.flatpickr', {
                enableTime: false,
                dateFormat: 'd/m/Y',
                locale: {
                    firstDayOfWeek: 1,
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

            ocultarMensajes();

            btnConsultar.addEventListener('click', function(event) {
                event.preventDefault();

                if (validarDatos()) {
                    datosDiv.style.display = 'none';
                    dividerDatos.style.display = 'none';
                    btnPdf.disabled = true;
                    loadingIndicator.style.display = 'block';

                    const data = {
                        id_empleado: administrativo.value || null,
                        id_cliente: cliente.value || null,
                        estado: estado.value || null,
                        concepto: concepto.value || null,
                        fechaDesde: fechaDesde.value ? convertirFecha(fechaDesde.value) : null,
                        fechaHasta: fechaHasta.value ? convertirFecha(fechaHasta.value) : null,
                    };

                    const urlApi = "{{ env('URL_SERVER_API') }}";
                    const url = `${urlApi}/reportes-pagos`;

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

                            tablePagosBody.innerHTML = '';

                            if (data.pagos && data.pagos.length > 0) {
                                data.pagos.forEach(pago => {
                                    const row = `
                                    <tr class="text-nowrap text-center">
                                        <th scope="row" class="align-middle">${pago.id}</th>
                                        <td class="align-middle">${pago.fecha}</td>
                                        <td class="align-middle">${pago.orden_de_trabajo.cotizacion.cliente.nombre} ${pago.orden_de_trabajo.cotizacion.cliente.apellido}</td>
                                        <td class="align-middle">${pago.orden_de_trabajo.cotizacion.empleado.nombre} ${pago.orden_de_trabajo.cotizacion.empleado.apellido}</td>
                                        <td class="align-middle">${pago.estado ? 'Pagado' : 'Pendiente'}</td>
                                        <td class="align-middle">${pago.concepto}</td>
                                        <td class="align-middle">Bs. ${formatearNumero(pago.monto)}</td>
                                    </tr>`;
                                    tablePagosBody.insertAdjacentHTML('beforeend', row);
                                });
                            } else {
                                const noResultsRow = `
                                <tr class="text-nowrap text-center">
                                    <td colspan="7" class="align-middle">No hay registros</td>
                                </tr>`;
                                tablePagosBody.insertAdjacentHTML('beforeend', noResultsRow);
                            }
                        })
                        .catch(error => console.error('Error en la petición fetch:', error));
                }
            });

            btnPdf.addEventListener('click', function(event) {
                event.preventDefault();
                generarPDF();
            });

            function generarPDF() {
                const url = `/dashboard/generar-reporte-pagos/pdf/${administrativo.value || 'null'}/${cliente.value || 'null'}/${estado.value || 'null'}/${concepto.value || 'null'}/${fechaDesde.value ? convertirFecha(fechaDesde.value) : 'null'}/${fechaHasta.value ? convertirFecha(fechaHasta.value) : 'null'}`;
                window.open(url, '_blank');
            }

            function validarDatos() {
                let valid = true;
                if (!fechaDesde.value && !fechaHasta.value && !administrativo.value && !cliente.value && !estado.value && !concepto.value) {
                    mostrarErrores();
                    valid = false;
                }
                return valid;
            }

            function mostrarErrores() {
                if (!fechaDesde.value) document.getElementById('mensajeFechaDesde').textContent = "El campo fecha desde es requerido.";
                if (!fechaHasta.value) document.getElementById('mensajeFechaHasta').textContent = "El campo fecha hasta es requerido.";
                if (!administrativo.value) document.getElementById('mensajeAdministrativo').textContent = "El campo administrativo es requerido.";
                if (!cliente.value) document.getElementById('mensajeCliente').textContent = "El campo cliente es requerido.";
                if (!estado.value) document.getElementById('mensajeEstado').textContent = "El campo estado es requerido.";
                if (!concepto.value) document.getElementById('mensajeConcepto').textContent = "El campo concepto es requerido.";
            }

            function verificarCampos() {
                btnPdf.disabled = !(fechaDesde.value && fechaHasta.value && administrativo.value && cliente.value && estado.value && concepto.value);
            }

            function ocultarMensajes() {
                const fields = [fechaDesde, fechaHasta, administrativo, cliente, estado, concepto];
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

            function formatearNumero(numero) {
                numero = parseFloat(numero);
                if (isNaN(numero)) return '0,00';
                return numero.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, '.').replace('.', ',');
            }
        });
    </script>
    @endpush

</x-layouts.app>