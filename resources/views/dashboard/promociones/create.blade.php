<x-layouts.app>
    <x-layouts.content title="Promociones" subtitle="Crear promoción" name="Promociones">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-circle-plus fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Registrar nueva promoción</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{ route('promociones.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre de la promoción</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Ej: Descuento de verano" value="{{ old('nombre') }}">
                                    @error('nombre')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descuento" class="control-label">Descuento (%)</label>
                                    <input type="number" class="form-control" id="descuento" name="descuento"
                                        placeholder="Ej: 15" value="{{ old('descuento') }}" min="0" max="100" step="0.01">
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
                                        value="{{ old('fecha_inicio') }}">
                                    @error('fecha_inicio')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_fin" class="control-label">Fecha de fin</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                                        value="{{ old('fecha_fin') }}">
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
                                            {{ in_array($producto->id, old('productos', [])) ? 'selected' : '' }}>
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
                                    <label for="descripcion" class="control-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3"
                                        placeholder="Descripción de la promoción">{{ old('descripcion') }}</textarea>
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
                                Guardar
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
