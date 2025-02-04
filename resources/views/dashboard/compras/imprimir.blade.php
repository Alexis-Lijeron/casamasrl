<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura de Compra - #{{ $compra->id }}</title>
    <style>
        /* Estilos generales para la impresión */
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
        .provider-info,
        .totales {
            width: 100%;
            margin-bottom: 20px;
        }

        .invoice-info td,
        .provider-info td,
        .totales td {
            padding: 5px;
        }

        .productos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .productos th,
        .productos td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        /* La sección no-print se mostrará en pantalla pero se ocultará al imprimir */
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
        // Función para actualizar dinámicamente los datos de dirección e identificación del proveedor en la factura
        function updateInvoiceProvider() {
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
            <label for="input-direccion"><strong>Dirección del Proveedor:</strong></label>
            <input type="text" id="input-direccion" value="{{ $compra->proveedor?->direccion ?? '' }}">
        </div>
        <div>
            <label for="input-identificacion"><strong>Identificación del Proveedor:</strong></label>
            <input type="text" id="input-identificacion" value="{{ $compra->proveedor?->identificacion ?? '' }}">
        </div>
        <div style="margin-top: 10px;">
            <button onclick="updateInvoiceProvider()">Actualizar Datos</button>
            <button onclick="window.print()">Imprimir Factura</button>
        </div>
        <hr>
    </div>

    <!-- Encabezado de la Empresa -->
    <div class="header">
        <h1>LACTEOS CASAMASRL</h1>
        <p>Dirección: Avenida Italia , entre Av.Cumavi y Libertador</p>
        <p>Teléfono: (+591) 76607405 | NIT: 13431977</p>
        <hr>
    </div>

    <!-- Información de la Factura -->
    <table class="invoice-info">
        <tr>
            <td><strong>N° de Factura:</strong> {{ $compra->id }}</td>
            <td><strong>Fecha de Compra:</strong> {{ formatearFecha($compra->fecha_compra) }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Registrado por:</strong> {{ $compra->usuario->nombre }} {{ $compra->usuario->apellido }}
            </td>
        </tr>
    </table>

    <!-- Información del Proveedor -->
    <table class="provider-info">
        <tr>
            <td>
                <strong>Proveedor:</strong> {{ $compra->proveedor->nombre_empresa }}<br>
                <strong>Encargado:</strong> {{ $compra->proveedor->nombre_encargado }}
            </td>
            <td>
                <strong>Dirección:</strong>
                <span id="invoice-direccion">{{ $compra->proveedor?->direccion ?? 'N/A' }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Identificación:</strong>
                <span id="invoice-identificacion">{{ $compra->proveedor?->identificacion ?? 'N/A' }}</span>
            </td>
        </tr>
    </table>

    <!-- Detalle de Productos Comprados -->
    <h2 style="text-align: center;">Detalle de Productos</h2>
    <table class="productos">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Almacén</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productosAsociados as $producto)
            <tr>
                <td>{{ $producto['nombre'] }}</td>
                <td>{{ $producto['almacenNombre'] }}</td>
                <td>{{ $producto['cantidad'] }}</td>
                <td>Bs. {{ number_format($producto['precio_compra'], 2, ',', '.') }}</td>
                <td>Bs. {{ number_format($producto['subtotal'], 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales de la Factura -->
    <table class="totales">
        <tr>
            <td style="text-align: right;"><strong>Total:</strong></td>
            <td style="text-align: center;">Bs. {{ number_format($compra->monto_total, 2, ',', '.') }}</td>
        </tr>
        <!-- Aquí puedes agregar otros totales, como impuestos o descuentos, si es necesario -->
    </table>

    <!-- Pie de Página -->
    <div class="footer">
        <hr>
        <p>¡Gracias por su compra!</p>
        <p>Factura generada por el sistema el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>