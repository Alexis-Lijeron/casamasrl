<x-layouts.app>
  <x-layouts.content title="Compras" subtitle="Detalles de compra" name="Compras">
    <div class="row">
      <div class="col-12">
        <div class="card-box">

          <div class="form-group px-4 pt-2">
            <i class="fas fa-edit fa-2x"></i>
            <h3 class="fs-1 d-inline-block ml-1">Detalles de la compra</h3>
            <a href="{{ route('compras.index') }}" class="btn btn-primary waves-effect waves-light float-right">
              <i class="fas fa-arrow-left"></i>&nbsp;
              Volver
            </a>
          </div>

          <div class="row px-4">
            <div class="col-md-4">
              <label class="font-17 d-block"><strong>Fecha de Compra:</strong></label>
              <span class="font-17">{{ formatearFecha($compra->fecha_compra) }}</span>
            </div>

            <div class="col-md-4">
              <label class="font-17 d-block"><strong>Proveedor:</strong></label>
              <span class="font-17 d-block">{{ $compra->proveedor->nombre_empresa }}</span>
              <span class="font-17">{{ $compra->proveedor->nombre_encargado }}</span>
            </div>

            <div class="col-md-4">
              <label class="font-17 d-block"><strong>Registrado por:</strong></label>
              <span class="font-17">{{ $compra->usuario->nombre }} {{ $compra->usuario->apellido }}</span>
            </div>
          </div>

          <div class="row px-4 mt-3">
            {{-- <div class="colmd-12"> --}}
              <div class="form-group col-md-12">
                {{-- <h3 class="mb-3">Productos Agregados</h3> --}}
                <table class="table table-bordered table-responsive-lg">
                  <thead class="bg-dark text-white ">
                    <tr>
                      <th class="text-center">Producto</th>
                      <th class="text-center">Almacen</th>
                      <th class="text-center">Cantidad</th>
                      <th class="text-center">Precio Unitario</th>
                      <th class="text-center">Subtotal</th>
                      <th class="text-center">Devolución</th>
                    </tr>
                  </thead>
                  <tbody id="productos-table-body">
                    @foreach ($productosAsociados as $producto)
                    <tr>
                      <td class="align-middle text-center">{{ $producto['nombre'] }}</td>
                      <td class="align-middle text-center">{{ $producto['almacenNombre'] }}</td>
                      <td class="align-middle text-center">{{ $producto['cantidad'] }} &nbsp;&nbsp;
                        @if (obtenerStockDisponibleAlmacen($producto['id'], $producto['almacenId']) <= 0)
                          <span class="badge badge-danger">
                            {{ obtenerStockDisponibleAlmacen($producto['id'], $producto['almacenId']) }}
                          </span>
                        @else
                          <span class="badge badge-success">
                            {{ obtenerStockDisponibleAlmacen($producto['id'], $producto['almacenId']) }}
                          </span>
                        @endif
                      </td>
                      <td class="align-middle text-center">Bs. {{ formatearNumero($producto['precio_compra']) }}</td>
                      <td class="align-middle text-center">Bs. {{ formatearNumero($producto['subtotal']) }}</td>
                      <td class="align-middle text-center">
                        <form id="formDevolucionCompra_{{ $compra->id }}"
                          action="{{ route('devoluciones.store', $compra->id) }}" method="POST">
                          @csrf
                          <button type="button" class="btn btn-sm btn-success mx-1"
                            onclick="mostrarModalDevolucion({{ $compra->id }}, {{ $producto['precio_compra'] }}, {{ $producto['productoAlmacenId'] }}, {{ $producto['cantidad'] }}, {{ obtenerStockDisponibleAlmacen($producto['id'], $producto['almacenId']) }})">
                            <i class="fas fa-truck-loading"></i>
                          </button>
                          <input type="hidden" name="cantidad" id="cantidad_{{ $compra->id }}">
                          <input type="hidden" name="motivo" id="motivo_{{ $compra->id }}">
                          <input type="hidden" name="monto_total" id="monto_{{ $compra->id }}">
                          <input type="hidden" name="producto_almacen_id" id="producto_almacen_id_{{ $compra->id }}">
                        </form>
                      </td>
                    </tr>
                    @endforeach
                    <tr>
                      <td colspan="3" class="align-middle text-center"></td>
                      <td class="align-middle text-center text-uppercase font-17"><strong>Total:</strong></td>
                      <td class="align-middle text-center font-17"><strong>Bs. {{ formatearNumero($compra->monto_total)
                          }}</strong></td>
                      <td class="align-middle text-center"></td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </x-layouts.content>

  @push('js')
  <script>
    function mostrarModalDevolucion(id, precioCompra, productoAlmacenId, cantidadProducto, cantidadDisponible) {
          Swal.fire({
              title: 'Devolver Compra',
              html: `
                  <div class="form-group text-left">
                      <label for="cantidad">Cantidad:</label>
                      <input type="number" id="cantidadInput" class="form-control" min="1" required>
                  </div>
                  <div class="form-group text-left">
                      <label for="motivo">Motivo:</label>
                      <textarea id="motivoInput" class="form-control" rows="3" required></textarea>
                  </div>
              `,
              showCancelButton: true,
              confirmButtonColor: '#556ee6',
              cancelButtonColor: '#f46a6a',
              confirmButtonText: 'Confirmar',
              cancelButtonText: 'Cancelar',
              preConfirm: () => {
                  const cantidad = Swal.getPopup().querySelector('#cantidadInput').value;
                  const motivo = Swal.getPopup().querySelector('#motivoInput').value;

                  if (!cantidad || !motivo) {
                      Swal.showValidationMessage('Por favor, complete ambos campos.');
                      return false;
                  }

                  return { cantidad, motivo };
              }
          }).then((result) => {
              if (result.isConfirmed) {
                  // Verificar que la cantidad a devolver no sea mayor a la cantidad comprada
                  if (result.value.cantidad > cantidadProducto) {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'La cantidad a devolver no puede ser mayor a la cantidad comprada.'
                    });
                    return;
                  }
                  
                  if (result.value.cantidad > cantidadDisponible) {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'La cantidad a devolver no puede ser mayor al stock disponible en el almacén.'
                    });
                    return;
                  }
                  
                  // Rellenar los campos ocultos del formulario
                  document.getElementById(`cantidad_${id}`).value = result.value.cantidad;
                  document.getElementById(`motivo_${id}`).value = result.value.motivo;
                  document.getElementById(`monto_${id}`).value = precioCompra * result.value.cantidad;
                  document.getElementById(`producto_almacen_id_${id}`).value = productoAlmacenId;
                  
                  // Enviar el formulario
                  document.getElementById(`formDevolucionCompra_${id}`).submit();
              }
          });
      }
  </script>
  @endpush


</x-layouts.app>