<h2>Resultados del Reporte</h2>

@if ($ventas->isNotEmpty())
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->fecha_venta }}</td>
            <td>{{ $venta->usuario->nombre }}</td>
            <td>{{ $venta->cliente->nombre }}</td>
            <td>
                @foreach ($venta->productosAlmacen as $producto)
                {{ $producto->producto->nombre }}<br>
                @endforeach
            </td>
            <td>
                @foreach ($venta->productosAlmacen as $producto)
                {{ $producto->producto->categoria->nombre }}<br>
                @endforeach
            </td>
            <td>Bs. {{ number_format($venta->monto_total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No se encontraron ventas con los filtros seleccionados.</p>
@endif