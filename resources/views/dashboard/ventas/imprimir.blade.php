<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura de Venta - #{{ $venta->id }}</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .invoice-info,
        .productos,
        .totales {
            width: 100%;
            margin-bottom: 20px;
        }

        .invoice-info td,
        .totales td {
            padding: 5px;
        }

        .productos {
            border-collapse: collapse;
        }

        .productos th,
        .productos td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        /* Los elementos con la clase no-print no se mostrarán al imprimir */
        .no-print {
            display: block;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
    <script>
        // Función que actualiza los campos de dirección e identificación en la factura
        function updateInvoice() {
            var direccion = document.getElementById('input-direccion').value;
            var identificacion = document.getElementById('input-identificacion').value;
            document.getElementById('invoice-direccion').innerText = direccion;
            document.getElementById('invoice-identificacion').innerText = identificacion;
        }
    </script>
</head>

<body>
    <!-- Sección para ingresar datos adicionales (no se imprimirá) -->
    <div class="no-print">
        <h2>Datos adicionales para la factura</h2>
        <div>
            <label for="input-direccion"><strong>Dirección:</strong></label>
            <input type="text" id="input-direccion" value="{{ $venta->cliente?->direccion ?? '' }}">
        </div>
        <div>
            <label for="input-identificacion"><strong>Identificación:</strong></label>
            <input type="text" id="input-identificacion" value="{{ $venta->cliente?->identificacion ?? '' }}">
        </div>
        <div style="margin-top: 10px;">
            <button onclick="updateInvoice()">Actualizar Datos</button>
            <button onclick="window.print()">Imprimir Factura</button>
        </div>
        <hr>
    </div>

    <!-- Encabezado de la empresa -->
    <div class="header">
        <h1>LACTEOS CASAMASRL</h1>
        <p>Dirección: Avenida Italia , entre Av.Cumavi y Libertador</p>
        <p>Teléfono: (+591) 76607405 | NIT: 13431977</p>
        <hr>
    </div>

    <!-- Información de la factura y del cliente -->
    <table class="invoice-info">
        <tr>
            <td><strong>N° de Factura:</strong> {{ $venta->id }}</td>
            <td><strong>Fecha y Hora:</strong> {{ formatearFecha($venta->fecha_venta) }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Registrado por:</strong> {{ $venta->usuario->nombre }} {{ $venta->usuario->apellido }}</td>
        </tr>
        <tr>
            <td>
                <strong>Cliente:</strong>
                {{ $venta->cliente?->nombre ?? 'No asignado' }} {{ $venta->cliente?->apellido ?? '' }}
            </td>
            <td>
                <strong>Dirección:</strong>
                <span id="invoice-direccion">{{ $venta->cliente?->direccion ?? 'N/A' }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Identificación:</strong>
                <span id="invoice-identificacion">{{ $venta->cliente?->identificacion ?? 'N/A' }}</span>
            </td>
        </tr>
    </table>

    <!-- Detalle de productos -->
    <h2 style="text-align: center;">Detalle de Productos</h2>
    <table class="productos">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productosAsociados as $producto)
            <tr>
                <td>{{ $producto['nombre'] }}</td>
                <td>{{ $producto['cantidad'] }}</td>
                <td>Bs. {{ number_format($producto['precio_venta'], 2, ',', '.') }}</td>
                <td>Bs. {{ number_format($producto['subtotal'], 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales de la factura -->
    <table class="totales">
        <tr>
            <td style="text-align: right;"><strong>Total:</strong></td>
            <td style="text-align: center;">Bs. {{ number_format($venta->monto_total, 2, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Pie de página -->
    <div class="footer">
        <hr>
        <p>¡Gracias por su compra!</p>
        <p>Factura generada por el sistema el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>