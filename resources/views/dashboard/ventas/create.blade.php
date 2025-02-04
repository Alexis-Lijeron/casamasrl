<x-layouts.app>
  <x-layouts.content title="Ventas" subtitle="Registrar venta" name="Ventas">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-box">

          <div class="form-group px-4 pt-2">
            <i class="fas fa-plus-circle fa-2x"></i>
            <h3 class="fs-1 d-inline-block ml-1">Registrar venta</h3>
          </div>


          <form class="px-4 pt-2 pb-2" action="{{ route('ventas.store') }}" method="POST">
            @csrf

            <div class="row">
              <div class="col-lg-8">
                <!-- Selección de Producto -->
                <div class="form-row align-items-end">
                  <div class="form-group col-lg-4">
                    <label for="producto_id" class="d-flex justify-content-between">Producto <span class="badge"
                        style="display: none;" id="stock-badge"></span></label>
                    <select id="producto_id" class="form-control" style="width: 100%;" data-toggle="select2">
                      <option value="">Seleccione un producto</option>
                      @foreach ($productos as $producto)
                            @php
                                // Obtener la promoción activa más reciente (si existe)
                                $promocionActiva = $producto->promociones
                                    ->where('estado', 'activo')
                                    ->where('fecha_inicio', '<=', now())
                                    ->where('fecha_fin', '>=', now())
                                    ->sortByDesc('fecha_inicio') // Para obtener la promoción más reciente
                                    ->first();

                                // Si hay promoción activa, usa el precio con descuento
                                $precioConDescuento = $promocionActiva ? $promocionActiva->pivot->precio_con_descuento : $producto->precio_venta;
                            @endphp

                            <option value="{{ $producto->id }}"
                                    data-nombre="{{ $producto->nombre }}"
                                    data-precio="{{ $producto->precio_venta }}"
                                    data-precio-descuento="{{ $precioConDescuento }}"
                                    data-stock="{{ obtenerStockDisponible($producto->id) }}"
                                    data-stock-minimo="{{ $producto->stock_minimo }}">
                                {{ $producto->nombre }}
                            </option>
                        @endforeach

                    </select>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" class="form-control" min="1" value="1">
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="precio_venta">Precio Unitario</label>
                    <input type="number" id="precio_venta" class="form-control" min="0" style="background: white;"
                      placeholder="0" step="0.01" readonly>
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
                          <th class="text-center">Cantidad</th>
                          <th class="text-center">Precio Unitario</th>
                          <th class="text-center">Subtotal</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody id="productos-table-body">
                        <tr id="mensaje-vacio" class="text-center">
                          <td colspan="5">No hay productos agregados.</td>
                        </tr>
                        <!-- Los productos se irán agregando aquí -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 bg-light rounded p-3">
                <h3 class="text-center mb-3">Datos de la Venta</h3>

                <!-- Fecha de Venta -->
                <div class="form-group">
                  <label for="fecha_venta">Fecha de Venta</label>
                  <input type="date" name="fecha_venta" style="background: white;" id="fecha_venta" class="form-control"
                    value="{{ date('Y-m-d') }}" readonly>
                  @error('fecha_venta')
                  <span class="error text-danger">* {{ $message }}</span>
                  @enderror
                </div>

                <!-- Selección de Cliente -->
                <div class="form-group">
                  <label for="cliente_id">Cliente</label>
                  <select name="cliente_id" id="cliente_id" class="form-control" style="width: 100%;"
                    data-toggle="select2">
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" @if($cliente['id']==old('cliente_id')) selected @endif>{{
                      $cliente->nombre }} {{
                      $cliente->apellido }}</option>
                    @endforeach
                  </select>
                  @error('cliente_id')
                  <span class="error text-danger">* {{ $message }}</span>
                  @enderror
                </div>

                <!-- Total de la Venta -->
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
                  <button type="submit" class="btn btn-lg btn-primary btn-block" id="guardar-venta">Guardar
                    Venta</button>
                  <a href="{{ route('ventas.index') }}" class="btn btn-lg btn-danger btn-block">
                    Cancelar
                  </a>
                </div>

                <!-- Productos ocultos para enviar al backend -->
                <input type="hidden" name="productos" id="productos-input">
              </div>
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
        title: '¿Está seguro de eliminar la venta?',
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
          form.submit();
        }
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      const productos = []; // Array para almacenar productos seleccionados
      const productoSelect = document.getElementById('producto_id');
      const cantidadInput = document.getElementById('cantidad');
      const precioInput = document.getElementById('precio_venta');
      const productosTableBody = document.getElementById('productos-table-body');
      const productosInput = document.getElementById('productos-input');
      const totalInput = document.getElementById('total');
      const mensajeVacio = document.getElementById('mensaje-vacio');
      const stockBadge = document.getElementById('stock-badge');

      productoSelect.addEventListener('change', function() {
        const selectedOption = productoSelect.options[productoSelect.selectedIndex];
        const precio = selectedOption.dataset.precio || 0;
        let precioDescuento = selectedOption.dataset.precioDescuento || precio;
        precioInput.value = precioDescuento;

        // Actualizar el texto del badge
        if (productoSelect.value) {
          const stock = selectedOption.dataset.stock;
          const stockMinimo = selectedOption.dataset.stockMinimo;

          stockBadge.style.display = 'inline-block'; // Mostrar el badge
          stockBadge.textContent = `${stock} en stock`;

          // Cambiar el color del badge según el stock
          if (stock >= stockMinimo) {
            stockBadge.classList.remove('badge-danger');
            stockBadge.classList.add('badge-success');
          } else {
            stockBadge.classList.remove('badge-success');
            stockBadge.classList.add('badge-danger');
          }
        } else {
          stockBadge.style.display = 'none'; // Ocultar el badge
        }
      });

      document.getElementById('agregar-producto').addEventListener('click', function() {
        const productoId = productoSelect.value;
        const productoNombre = productoSelect.options[productoSelect.selectedIndex]?.text;
        const cantidad = parseInt(cantidadInput.value, 10) || 0;
        const precioUnitario = parseFloat(precioInput.value);
        const stock = parseInt(productoSelect.options[productoSelect.selectedIndex]?.dataset.stock, 10) || 0;

        if (!productoId) {
          mostrarAlerta('Oops!', 'Seleccione un producto válido.', 'info');
          return;
        }

        if (cantidad <= 0) {
          mostrarAlerta('Oops!', 'La cantidad debe ser mayor a 0.', 'info');
          return;
        }

        if (cantidad > stock) {
          mostrarAlerta('Oops!', 'La cantidad supera el stock disponible.', 'info');
          return;
        }

        if (productos.some(producto => producto.productoId === productoId)) {
          mostrarAlerta('Oops!', 'El producto ya está agregado.', 'info');
          return;
        }

        const subtotal = cantidad * precioUnitario;

        productos.push({
          productoId,
          productoNombre,
          cantidad,
          precioUnitario,
          subtotal
        });

        renderTable();
        updateTotal();

        cantidadInput.value = 1;
        precioInput.value = '';
        productoSelect.value = '';
        stockBadge.style.display = 'none'; // Ocultar el badge
      });

      function renderTable() {
        productosTableBody.innerHTML = '';
        productos.forEach((producto, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
                    <td class="align-middle text-center">${producto.productoNombre}</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-sm btn-outline-danger me-2" onclick="disminuirCantidad(${index})">-</button>
                            <span class="mx-3">${producto.cantidad}</span>
                            <button type="button" class="btn btn-sm btn-outline-success ms-2" onclick="aumentarCantidad(${index})">+</button>
                        </div>
                    </td>
                    <td class="align-middle text-center">${producto.precioUnitario.toFixed(2)}</td>
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
        productos[index].subtotal = productos[index].cantidad * productos[index].precioUnitario;
        renderTable();
        updateTotal();
      };

      window.disminuirCantidad = function(index) {
        if (productos[index].cantidad > 1) {
          productos[index].cantidad--;
          productos[index].subtotal = productos[index].cantidad * productos[index].precioUnitario;
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
