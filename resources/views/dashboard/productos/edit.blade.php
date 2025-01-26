<x-layouts.app>

  <x-layouts.content title="Productos" subtitle="Editar producto" name="Productos">

      <div class="row">
          <div class="col-12">
              <div class="card-box">

                  <div class="form-group px-4 pt-2">
                      <i class="fas fa-pencil-alt fa-2x"></i>
                      <h3 class="fs-1 d-inline-block ml-1">Editar producto</h3>
                  </div>

                  <form class="px-4 pt-2 pb-2" action="{{ route('productos.update', $producto['id']) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="nombre" class="control-label">Nombre</label>
                                  <input type="text" class="form-control" id="nombre" name="nombre"
                                      placeholder="Ej: Paracetamol" value="{{ old('nombre', $producto->nombre) }}">
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
                                      @if($categoria['id'] == old('categoria_id', $producto->categoria_id)) selected @endif>
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
                                    @if($marca['id'] == old('marca_id', $producto->marca_id)) selected @endif>
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
                                      name="stock_minimo" placeholder="Ej: 10" value="{{ old('stock_minimo', $producto->stock_minimo) }}">
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
                                          id="precio_venta" value="{{ old('precio_venta', $producto->precio_venta) }}">
                                  </div>
                                  @error('precio_venta')
                                  <span class="error text-danger">* {{ $message }}</span>
                                  @enderror
                              </div>

                              <div class="form-group">
                                  <label for="descripcion" class="control-label">Descripción</label>
                                  <textarea class="form-control" name="descripcion" id="descripcion" rows="5"
                                      placeholder="Introduzca la descripción">{{ old('descripcion', $producto->descripcion) }}</textarea>
                                  @error('descripcion')
                                  <span class="error text-danger">* {{ $message }}</span>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="imagen">Seleccionar Imagen</label>
                                  <input type="file" class="form-control-file" id="imagen" name="imagen"
                                      accept="image/*">
                                  @error('imagen')
                                  <span class="error text-danger">* {{ $message }}</span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                  <img id="preview-imagen" src="{{ $producto->url_imagen }}" alt="Previsualización"
                                      style="max-width: 200px; margin-top: 10px;">
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
    document.getElementById('imagen').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-imagen').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
  </script>
  @endpush

</x-layouts.app>