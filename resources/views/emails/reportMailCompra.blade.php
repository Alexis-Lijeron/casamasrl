<div>
    <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Reporte de Compras</h2>
    <table style="border-collapse: collapse; border: 1px solid #ddd;">
        <thead>
            <tr>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">ID</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Fecha</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Usuario</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Cliente</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Producto</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Categoría</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($content as $compra)
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $compra->id }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $compra->fecha_compra }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $compra->usuario->nombre }} {{ $compra->usuario->apellido }}
                </td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $compra->proveedor->nombre_empresa }} - {{ $compra->proveedor->nombre_encargado }}
                </td>
                <td style="padding: 8px; border: 1px solid #ddd;">
                    <ul style="padding-left: 20px;">
                        @foreach($compra->productos_almacen as $detalle)
                        <li>{{ $detalle->producto->nombre }}</li>
                        @endforeach
                    </ul>
                </td>
                <td style="padding: 8px; border: 1px solid #ddd;">
                    <ul style="padding-left: 20px;">
                        @foreach($compra->productos_almacen as $detalle)
                        <li>{{ $detalle->producto->categoria->nombre }}</li>
                        @endforeach
                    </ul>
                </td>
                <td style="padding: 8px; border: 1px solid #ddd;">Bs. {{ $compra->monto_total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>