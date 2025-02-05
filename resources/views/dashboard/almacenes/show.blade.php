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
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No hay productos en este almacén.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        @if(auth()->user()->hasPermission('almacenes.editar'))
                        <a href="{{ route('almacenes.edit', $almacen->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </x-layouts.content>

</x-layouts.app>