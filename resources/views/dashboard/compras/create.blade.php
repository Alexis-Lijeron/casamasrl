<x-layouts.app>
  <x-layouts.content title="Compras" subtitle="Registrar compra" name="Compras">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-box">

          <div class="form-group px-4 pt-2">
            <i class="fas fa-plus-circle fa-2x"></i>
            <h3 class="fs-1 d-inline-block ml-1">Registrar compra</h3>
          </div>


          <form class="px-4 pt-2 pb-2" action="{{ route('compras.store') }}" method="POST">
            @csrf

            <div class="row">
              <div class="col-lg-8">
                <div class="form-row align-items-end">
                  <div class="form-group col-lg-4">
                    <label for="almacen_id">Almacen</label>
                    <select id="almacen_id" class="form-control" style="width: 100%;" data-toggle="select2">
                      <option value="">Seleccione un almacen</option>
                      @foreach ($almacenes as $almacen)
                      <option value="{{ $almacen->id }}" data-nombre=""
                        data-precio="">
                        {{ $almacen->nombre }}
                      </option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Selección de Producto -->
                  <div class="form-group col-lg-4">
                    <label for="producto_id">Producto</label>
                    <select id="producto_id" class="form-control" style="width: 100%;" data-toggle="select2" disabled>
                      <option value="">Seleccione un producto</option>
                      {{-- @foreach ($productos as $producto)
                      <option value="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}"
                      data-precio="{{ $producto->precio }}">
                      {{ $producto->nombre }}
                      </option>
                      @endforeach --}}
                    </select>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" class="form-control" min="1" value="1">
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="precio_compra">Precio de Compra</label>
                    <input type="number" id="precio_compra" class="form-control" min="0" placeholder="0" step="0.01">
                  </div>

                  <div class="form-group col-lg-2">
                    <button type="button" class="btn btn-success btn-block" id="agregar-producto">Agregar</button>
                  </div>
                </div>
                @error('productos')
                <span class="error text-danger">* {{ $message }}</span>
                @enderror

                <div class="form-row align-items-end mt-2">
                  <!-- Tabla de Productos Agregados -->
                  <div class="form-group col-lg-12">
                    <h3 class="mb-3">Productos Agregados</h3>
                    <table class="table table-bordered">
                      <thead class="bg-dark text-white ">
                        <tr>
                          <th class="text-center">Producto</th>
                          <th class="text-center">Almacen</th>
                          <th class="text-center">Cantidad</th>
                          <th class="text-center">Precio Unitario</th>
                          <th class="text-center">Subtotal</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody id="productos-table-body">
                        <tr id="mensaje-vacio" class="text-center">
                          <td colspan="6">No hay productos agregados.</td>
                        </tr>
                        <!-- Los productos se irán agregando aquí -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 bg-light rounded p-3">
                <h3 class="text-center mb-3">Datos de la Compra</h3>

                <!-- Fecha de Compra -->
                <div class="form-group">
                  <label for="fecha_compra">Fecha de Compra</label>
                  <input type="date" name="fecha_compra" style="background: white;" id="fecha_compra"
                    class="form-control" value="{{ date('Y-m-d') }}" readonly>
                  @error('fecha_compra')
                  <span class="error text-danger">* {{ $message }}</span>
                  @enderror
                </div>

                <!-- Selección de Proveedor -->
                <div class="form-group">
                  <label for="proveedor_id">Proveedor</label>
                  <select name="proveedor_id" id="proveedor_id" class="form-control" style="width: 100%;"
                    data-toggle="select2">
                    <option value="">Seleccione un proveedor</option>
                    @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" @if($proveedor['id']==old('proveedor_id')) selected @endif>{{
                      $proveedor->nombre_empresa }} - {{
                      $proveedor->nombre_encargado }}</option>
                    @endforeach
                  </select>
                  @error('proveedor_id')
                  <span class="error text-danger">* {{ $message }}</span>
                  @enderror
                </div>

                <!-- Total de la Compra -->
                <div class="form-group">
                  <label for="total">Total</label>
                  <input type="number" style="background: white;" name="total" id="total" class="form-control"
                    step="0.01" value="0.00" readonly>
                  @error('total')
                  <span class="error text-danger">* {{ $message }}</span>
                  @enderror
                </div>

                <!-- Botón de Guardar -->
                <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-primary btn-block" id="guardar-compra">Guardar
                    Compra</button>
                  <a href="{{ route('compras.index') }}" class="btn btn-lg btn-danger btn-block">
                    Cancelar
                  </a>
                </div>

                <!-- Productos ocultos para enviar al backend -->
                <input type="hidden" name="productos" id="productos-input">
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </x-layouts.content>

  @push('js')
  <script>
    function confirmDelete(id) {
      Swal.fire({
        title: '¿Está seguro de cancelar la venta?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#556ee6',
        cancelButtonColor: '#f46a6a',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.getElementById(`formDeleteVenta_${id}`);
          form.submit(); // Envía el formulario si el usuario confirma
        }
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      const productos = []; // Array para almacenar productos seleccionados
      const productoSelect = document.getElementById('producto_id');
      const almacenSelect = document.getElementById('almacen_id');
      const cantidadInput = document.getElementById('cantidad');
      const precioInput = document.getElementById('precio_compra');
      const productosTableBody = document.getElementById('productos-table-body');
      const productosInput = document.getElementById('productos-input');
      const totalInput = document.getElementById('total');
      const mensajeVacio = document.getElementById('mensaje-vacio');

      almacenSelect.addEventListener('change', function() {
        const almacenId = this.value;

        productoSelect.innerHTML = '<option value="">Cargando...</option>';
        productoSelect.disabled = true;

        // Verificar que el almacén seleccionado no esté vacío
        if (almacenId && almacenId.trim() !== "") {
          const url = "{{ route('compras.obtenerProductosPorAlmacen', ':almacenId') }}".replace(':almacenId', almacenId);
          fetch(url)
            .then(response => response.json())
            .then(productos => {
              productoSelect.innerHTML = '<option value="">Seleccione un producto</option>';
              productos.forEach(producto => {
                const option = document.createElement('option');
                option.value = producto.producto_id;
                option.textContent = producto.producto_nombre;

                // Asignar atributos data al option
                option.setAttribute('data-producto-almacen-id', producto.id);
                option.setAttribute('data-precio', producto.precio);

                productoSelect.appendChild(option);
              });
              productoSelect.disabled = false;
            })
            .catch(error => {
              console.error('Error al cargar los productos:', error);
              productoSelect.innerHTML = '<option value="">Error al cargar productos</option>';
            });
        } else {
          productoSelect.innerHTML = '<option value="">Seleccione un producto</option>';
        }
      });

      productoSelect.addEventListener('change', function() {
        const selectedOption = productoSelect.options[productoSelect.selectedIndex];
        precioInput.value = selectedOption.getAttribute('data-precio') || 0;
      });

      document.getElementById('agregar-producto').addEventListener('click', function() {
        const productoId = productoSelect.value;
        const almacenNombre = almacenSelect.options[almacenSelect.selectedIndex].text;
        const productoNombre = productoSelect.options[productoSelect.selectedIndex]?.text;
        const productoAlmacenId = productoSelect.options[productoSelect.selectedIndex]?.getAttribute('data-producto-almacen-id');
        const cantidad = parseInt(cantidadInput.value, 10);
        const precioCompra = parseFloat(precioInput.value);

        if (!productoId) {
          mostrarAlerta('Oops!', 'Seleccione un producto válido.', 'info');
          return;
        }

        if (cantidad <= 0) {
          mostrarAlerta('Oops!', 'La cantidad debe ser mayor a 0.', 'info');
          return;
        }

        if (precioCompra <= 0) {
          mostrarAlerta('Oops!', 'El precio de compra debe ser mayor a 0.', 'info');
          return;
        }

        if (productos.some(producto => producto.productoId === productoId && producto.almacenNombre === almacenNombre)) {
          mostrarAlerta('Oops!', 'El producto ya está agregado en este almacén.', 'info');
          return;
        }

        const subtotal = cantidad * precioCompra;
        productos.push({
          productoId,
          productoNombre,
          almacenNombre,
          cantidad,
          precioCompra,
          subtotal,
          productoAlmacenId
        });
        renderTable();
        updateTotal();

        cantidadInput.value = 1;
        precioInput.value = '';
        productoSelect.value = '';
      });

      function renderTable() {
        productosTableBody.innerHTML = '';
        productos.forEach((producto, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
                    <td class="align-middle text-center">${producto.productoNombre}</td>
                    <td class="align-middle text-center">${producto.almacenNombre}</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-sm btn-outline-danger me-2" onclick="disminuirCantidad(${index})">-</button>
                            <span class="mx-3">${producto.cantidad}</span>
                            <button type="button" class="btn btn-sm btn-outline-success ms-2" onclick="aumentarCantidad(${index})">+</button>
                        </div>
                    </td>
                    <td class="align-middle text-center">${producto.precioCompra.toFixed(2)}</td>
                    <td class="align-middle text-center">${producto.subtotal.toFixed(2)}</td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})"><i class="fas fa-trash-alt"></i></button>
                    </td>
                `;
          productosTableBody.appendChild(row);
        });

        if (productos.length === 0) {
          productosTableBody.appendChild(mensajeVacio);
        }

        productosInput.value = JSON.stringify(productos);
      }

      window.aumentarCantidad = function(index) {
        productos[index].cantidad++;
        productos[index].subtotal = productos[index].cantidad * productos[index].precioCompra;
        renderTable();
        updateTotal();
      };

      window.disminuirCantidad = function(index) {
        if (productos[index].cantidad > 1) {
          productos[index].cantidad--;
          productos[index].subtotal = productos[index].cantidad * productos[index].precioCompra;
          renderTable();
          updateTotal();
        }
      };

      window.eliminarProducto = function(index) {
        productos.splice(index, 1);
        renderTable();
        updateTotal();
      };

      function updateTotal() {
        const total = productos.reduce((sum, producto) => sum + producto.subtotal, 0);
        totalInput.value = total.toFixed(2);
      }

      function mostrarAlerta(titulo, mensaje, tipo, tiempo = 3000) {
        Swal.fire({
          title: titulo,
          text: mensaje,
          icon: tipo,
          timer: tiempo
        });
      }
    });
  </script>
  @endpush


</x-layouts.app>