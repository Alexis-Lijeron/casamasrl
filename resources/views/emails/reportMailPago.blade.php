<div>
    <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Reporte de Pagos</h2>
    <table style="border-collapse: collapse; border: 1px solid #ddd;">
        <thead>
            <tr>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">ID</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Fecha</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Usuario</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Cliente</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Estado</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Metodo Pago</th>
                <th style="padding: 8px; text-align: left; background-color: #f4f4f4; border: 1px solid #ddd;">Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($content as $pago)
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pago->id }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pago->fecha_pago }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pago->nota_venta->usuario->nombre }} {{
          $pago->nota_venta->usuario->apellido }}
                </td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pago->nota_venta->cliente->nombre }} {{
          $pago->nota_venta->cliente->apellido }}
                </td>
                <td style="padding: 8px; border: 1px solid #ddd;">
                    <ul style="padding-left: 20px;">{{ $pago->estado ? 'Pagado' : 'Pendiente' }}
                </td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $pago->metodo_pago->nombre ?? 'No asignado' }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">Bs. {{ $pago->monto }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>