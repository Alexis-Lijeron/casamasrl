<x-layouts.app>
    <x-layouts.content title="Promociones" subtitle="Editar promoción" name="Promociones">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-edit fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Editar promoción</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{ route('promociones.update', $promocion->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre de la promoción</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="{{ old('nombre', $promocion->nombre) }}">
                                    @error('nombre')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descuento" class="control-label">Descuento (%)</label>
                                    <input type="number" class="form-control" id="descuento" name="descuento"
                                        value="{{ old('descuento', $promocion->descuento) }}" min="0" max="100" step="0.01">
                                    @error('descuento')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_inicio" class="control-label">Fecha de inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                        value="{{ old('fecha_inicio', $promocion->fecha_inicio->format('Y-m-d')) }}">
                                    @error('fecha_inicio')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_fin" class="control-label">Fecha de fin</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                                        value="{{ old('fecha_fin', $promocion->fecha_fin->format('Y-m-d')) }}">
                                    @error('fecha_fin')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="productos" class="control-label">Productos</label>
                                    <select class="form-control select2" name="productos[]" id="productos" multiple>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                            {{ in_array($producto->id, old('productos', $promocion->productos->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $producto->nombre }} - Bs. {{ $producto->precio_venta }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('productos')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="estado" class="control-label">Estado</label>
                                    <select class="form-control" name="estado" id="estado">
                                        <option value="activo" {{ $promocion->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ $promocion->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    @error('estado')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3">{{ old('descripcion', $promocion->descripcion) }}</textarea>
                                    @error('descripcion')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right m-b-0">
                            <a href="{{ route('promociones.index') }}" class="btn btn-danger waves-effect m-l-5">
                                Cancelar
                            </a>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-layouts.content>

    @push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    @endpush
</x-layouts.app>
