<x-layouts.app>
    <x-layouts.content title="Productos Almacenados" subtitle="Gestión de Productos por Vencimiento" name="Productos Almacenados">
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-search fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Gestión de Productos por Vencimiento</h3>
                    </div>

                    <!-- Botones de navegación -->
                    <div class="row px-4 mb-3">
                        <div class="col-md-12 d-flex justify-content-start">
                            <a href="{{ route('almacenes.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>
                            <button id="print-button" class="btn btn-info">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <form id="filter-form" method="GET" action="{{ route('almacenes.vencimientos') }}">
                        <div class="row px-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date">Fecha Inicio</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request()->get('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date">Fecha Fin</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request()->get('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter_type">Filtro</label>
                                    <select class="form-control" id="filter_type" name="filter_type">
                                        <option value="vencidos" {{ request()->get('filter_type') == 'vencidos' ? 'selected' : '' }}>Vencidos</option>
                                        <option value="proximos" {{ request()->get('filter_type') == 'proximos' ? 'selected' : '' }}>Próximos a Vencer</option>
                                        <option value="rango" {{ request()->get('filter_type') == 'rango' ? 'selected' : '' }}>Por Rango de Fechas</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row px-4">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Tabla de Productos -->
                    <div id="vencimientos-detalles" class="px-4 pt-2">
                        <h4 class="mb-3">Resultados</h4>
                        <div class="table-responsive">
                            <table id="results-table" class="table table-hover">
                                <thead class="bg-dark text-white text-center">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Almacén</th>
                                        <th>Stock Disponible</th>
                                        <th>Fecha de Vencimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos as $producto)
                                    <tr class="text-center">
                                        <td>{{ $producto->producto->nombre }}</td>
                                        <td>{{ $producto->almacen->nombre }}</td>
                                        <td>
                                            <span class="badge" style="background-color: #556ee6">
                                                {{ $producto->stock }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                            $fechaVencimiento = $producto->fecha_vencimiento;
                                            $fechaFormateada = $fechaVencimiento ? date('d/m/Y', strtotime($fechaVencimiento)) : '-- Sin fecha --';
                                            @endphp
                                            <span class="badge"
                                                @if($fechaVencimiento && strtotime($fechaVencimiento) < strtotime(now()))
                                                style="background-color: #f46a6a" {{-- Rojo: Vencido --}}
                                                @elseif($fechaVencimiento && strtotime($fechaVencimiento) <=strtotime('+1 month'))
                                                style="background-color: #f4a261" {{-- Amarillo: Próximo a vencer --}}
                                                @else
                                                style="background-color: #2a9d8f" {{-- Verde: Fecha válida --}}
                                                @endif>
                                                {{ $fechaFormateada }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No se encontraron productos para este filtro.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </x-layouts.content>

    @push('js')
    <script>
        document.getElementById('print-button').addEventListener('click', function() {
            const filterType = document.getElementById('filter_type').value;
            const filterText = document.getElementById('filter_type').options[document.getElementById('filter_type').selectedIndex].text;
            const startDate = document.getElementById('start_date').value || 'N/A';
            const endDate = document.getElementById('end_date').value || 'N/A';

            let dateRangeContent = '';
            if (filterType === 'rango') {
                dateRangeContent = `
                    <p><strong>Fecha de Inicio:</strong> ${startDate}</p>
                    <p><strong>Fecha de Fin:</strong> ${endDate}</p>
                `;
            }

            const content = document.getElementById('vencimientos-detalles').innerHTML;
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Reporte de Productos por Vencimiento</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            th, td { border: 1px solid #ddd; text-align: center; padding: 8px; }
                            th { background-color: #343a40; color: white; }
                            .badge { padding: 5px 10px; border-radius: 5px; color: white; font-weight: bold; }
                            @media print {
                                body { -webkit-print-color-adjust: exact; }
                                .badge { color: white; }
                            }
                            .badge.vencido { background-color: #f46a6a; }
                            .badge.proximo { background-color: #f4a261; }
                            .badge.valido { background-color: #2a9d8f; }
                        </style>
                    </head>
                    <body>
                        <h1>Reporte de Productos por Vencimiento</h1>
                        ${dateRangeContent}
                        <p><strong>Filtro Aplicado:</strong> ${filterText}</p>
                        ${content}
                        <footer style="margin-top: 20px; text-align: center; font-size: 12px; color: #777;">
                            Generado el: ${new Date().toLocaleString()}
                        </footer>
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        });
    </script>
    @endpush
</x-layouts.app>