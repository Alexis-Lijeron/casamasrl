<x-layouts.app>

    <x-layouts.content title="Almacenes" subtitle="Detalles del almacén" name="Almacenes">
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-eye fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Detalles del Almacén</h3>
                    </div>

                    <!-- Información del almacén -->
                    <div id="almacen-detalles">
                        <div class="row px-4 pt-2">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> {{ $almacen->nombre }}</p>
                                <p><strong>Descripción:</strong> {{ $almacen->descripcion ?? '-- Sin descripción --' }}</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Lista de productos en el almacén -->
                        <div class="px-4 pt-2">
                            <h4 class="mb-3">Productos almacenados</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-dark text-white text-center">
                                        <tr>
                                            <th>Producto</th>
                                            <th>Stock Disponible</th>
                                            <th>Fecha de Vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($almacen->productos as $producto)
                                        <tr class="text-center">
                                            <td>{{ $producto->nombre }}</td>
                                            <td>
                                                <span class="badge"
                                                    @if(obtenerStockDisponibleAlmacen($producto->id, $almacen->id) == 0)
                                                    style="background-color: #f46a6a"
                                                    @else
                                                    style="background-color: #556ee6"
                                                    @endif
                                                    >
                                                    {{ obtenerStockDisponibleAlmacen($producto->id, $almacen->id) }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                $fechaVencimiento = $producto->pivot->fecha_vencimiento;
                                                $fechaFormateada = $fechaVencimiento ? date('d/m/Y', strtotime($fechaVencimiento)) : '-- Sin fecha --';

                                                // Evaluar estados
                                                $estadoFecha = '';
                                                if ($fechaVencimiento) {
                                                $fechaTimestamp = strtotime($fechaVencimiento);
                                                $hoyTimestamp = strtotime(now());
                                                $unMesDespuesTimestamp = strtotime('+1 month');

                                                if ($fechaTimestamp < $hoyTimestamp) {
                                                    $estadoFecha='vencido' ; // Producto vencido
                                                    } elseif ($fechaTimestamp <=$unMesDespuesTimestamp) {
                                                    $estadoFecha='proximo' ; // Próximo a vencer
                                                    } else {
                                                    $estadoFecha='valido' ; // Fecha válida
                                                    }
                                                    }
                                                    @endphp

                                                    <span class="badge"
                                                    @if($estadoFecha==='vencido' )
                                                    style="background-color: #f46a6a" {{-- Rojo: Vencido --}}
                                                    @elseif($estadoFecha==='proximo' )
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
                                            <td colspan="3" class="text-center">No hay productos en este almacén.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 text-right mt-3">
                        <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        @if(auth()->user()->hasPermission('almacenes.editar'))
                        <a href="{{ route('almacenes.edit', $almacen->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        @endif
                        <button id="print-button" class="btn btn-info">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </x-layouts.content>

    @push('js')
    <script>
        document.getElementById('print-button').addEventListener('click', function() {
            const content = document.getElementById('almacen-detalles').innerHTML;
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Detalles del Almacén</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            th, td { border: 1px solid #ddd; text-align: center; padding: 8px; }
                            th { background-color: #f4f4f4; }
                            .badge { padding: 5px 10px; border-radius: 5px; color: white; }
                        </style>
                    </head>
                    <body>
                        <h1>Detalles del Almacén</h1>
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