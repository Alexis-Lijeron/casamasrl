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

</x-layouts.app>