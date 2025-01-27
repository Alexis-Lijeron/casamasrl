<x-layouts.app>

    <x-layouts.content title="Productos" subtitle="Crear producto" name="Productos">

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-circle-plus fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Registrar nuevo producto</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{ route('productos.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Ej: Paracetamol" value="{{ old('nombre') }}">
                                    @error('nombre')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoria_id" class="control-label">Categoría</label>
                                    <select class="form-control" data-toggle="select2" name="categoria_id" id="categoria_id">
                                        <option value="">Seleccionar</option>
                                        @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria['id'] }}"
                                        @if($categoria['id'] == old('categoria_id')) selected @endif>
                                            {{ $categoria['nombre'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="marca_id" class="control-label">Marca</label>
                                    <select class="form-control" data-toggle="select2" name="marca_id" id="marca_id">
                                        <option value="">Seleccionar</option>
                                        @foreach ($marcas as $marca)
                                        <option value="{{ $marca['id'] }}"
                                        @if($marca['id'] == old('marca_id')) selected @endif>
                                            {{ $marca['nombre'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('marca_id')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock_minimo" class="control-label">Stock mínimo</label>
                                    <input type="number" min="0" class="form-control" id="stock_minimo"
                                        name="stock_minimo" placeholder="Ej: 10" value="{{ old('stock_minimo') }}">
                                    @error('stock_minimo')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Precio de venta</label>
                                    <div class="input-group mt-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Bs</span>
                                        </div>
                                        <input type="number" class="form-control" placeholder="Ej: 150,5"
                                            aria-label="Amount (to the nearest dollar)" name="precio_venta"
                                            id="precio_venta" value="{{ old('precio_venta') }}" step="0.01">
                                    </div>
                                    @error('precio_venta')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="5"
                                        placeholder="Introduzca la descripción">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imagen">Seleccionar Imagen</label>
                                    <input type="file" class="form-control-file" id="imagen" name="imagen"
                                        accept="image/*" onchange="mostrarPrevisualizacion(event)">
                                    @error('imagen')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <img id="preview-imagen" src="" alt="Previsualización"
                                        style="display: none; max-width: 200px; margin-top: 10px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right m-b-0">
                            <a href="{{ route('productos.index') }}" class="btn btn-danger waves-effect m-l-5">
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
        function mostrarPrevisualizacion(event) {
            const input = event.target;
            const preview = document.getElementById('preview-imagen');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result; // Establece la imagen cargada como src
                    preview.style.display = 'block'; // Muestra la imagen
                };

                reader.readAsDataURL(input.files[0]); // Lee el archivo seleccionado
            } else {
                preview.src = '';
                preview.style.display = 'none'; // Oculta la previsualización si no hay imagen seleccionada
            }
        }
    </script>
    @endpush

</x-layouts.app>
