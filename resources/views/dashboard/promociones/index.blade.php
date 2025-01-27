<x-layouts.app>
    <x-layouts.content title="Promociones" subtitle="" name="Promociones">
        <div class="row">
            <div class="col-12">
                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        <a href="{{ route('promociones.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nueva Promoción
                        </a>
                    </div>
                </div>

                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-promociones" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descuento</th>
                                    <th scope="col">Fecha Inicio</th>
                                    <th scope="col">Fecha Fin</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Productos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promociones as $promocion)
                                <tr class="text-center">
                                    <th scope="row" class="align-middle">{{ $promocion->id }}</th>
                                    <td class="align-middle">{{ $promocion->nombre }}</td>
                                    <td class="align-middle">{{ $promocion->descuento }}%</td>
                                    <td class="align-middle">{{ $promocion->fecha_inicio->format('d/m/Y') }}</td>
                                    <td class="align-middle">{{ $promocion->fecha_fin->format('d/m/Y') }}</td>
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $promocion->estado === 'activo' ? 'success' : 'danger' }}">
                                            {{ $promocion->estado }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        {{ $promocion->productos->count() }} productos
                                    </td>
                                    <td class="align-middle text-nowrap">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('promociones.edit', $promocion->id) }}"
                                               class="btn btn-sm btn-primary mx-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="formDeletePromocion_{{ $promocion->id }}"
                                                  action="{{ route('promociones.destroy', $promocion->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        onclick="confirmDelete({{ $promocion->id }})"
                                                        class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.content>
</x-layouts.app>
