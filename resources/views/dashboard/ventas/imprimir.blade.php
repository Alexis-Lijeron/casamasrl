<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura de Venta - #{{ $venta->id }}</title>
    <style>
        /* Estilos Generales */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            background-color: #fff;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }

        header,
        footer {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            color: #444;
        }

        header p,
        footer p {
            margin: 5px 0;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }

        /* Sección no imprimible */
        .no-print {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .no-print h2 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }

        .form-group input {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 300px;
        }

        button {
            padding: 6px 12px;
            margin-right: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        /* Se ocultan elementos no deseados en la impresión */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
    <script>
        // Actualiza los campos de dirección e identificación en la factura
        function updateInvoice() {
            var direccion = document.getElementById('input-direccion').value;
            var identificacion = document.getElementById('input-identificacion').value;
            document.getElementById('invoice-direccion').innerText = direccion;
            document.getElementById('invoice-identificacion').innerText = identificacion;
        }
    </script>
</head>

<body>
    <div class="container">
        <!-- Datos adicionales (no se imprime) -->
        <div class="no-print">
            <h2>Datos adicionales para la factura</h2>
            <div class="form-group">
                <label for="input-direccion">Dirección:</label>
                <input type="text" id="input-direccion" value="{{ $venta->cliente?->direccion ?? '' }}">
            </div>
            <div class="form-group">
                <label for="input-identificacion">Identificación:</label>
                <input type="text" id="input-identificacion" value="{{ $venta->cliente?->identificacion ?? '' }}">
            </div>
            <div>
                <button onclick="updateInvoice()">Actualizar Datos</button>
                <button onclick="window.print()">Imprimir Factura</button>
            </div>
            <hr>
        </div>

        <!-- Encabezado de la Empresa -->
        <header>
            <h1>LACTEOS CASAMASRL</h1>
            <p>Dirección: Avenida Italia, entre Av. Cumavi y Libertador</p>
            <p>Teléfono: (+591) 76607405 | NIT: 13431977</p>
            <hr>
        </header>

        <!-- Información de la Factura -->
        <table>
            <tr>
                <td><strong>N° de Factura:</strong> {{ $venta->id }}</td>
                <td><strong>Fecha y Hora:</strong> {{ formatearFecha($venta->fecha_venta) }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Registrado por:</strong> {{ $venta->usuario->nombre }} {{ $venta->usuario->apellido }}
                </td>
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

        <!-- Detalle de Productos -->
        <h2 style="text-align: center;">Detalle de Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th class="text-right">Precio Unitario</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosAsociados as $producto)
                <tr>
                    <td>{{ $producto['nombre'] }}</td>
                    <td>{{ $producto['cantidad'] }}</td>
                    <td class="text-right">Bs. {{ number_format($producto['precio_venta'], 2, ',', '.') }}</td>
                    <td class="text-right">Bs. {{ number_format($producto['subtotal'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totales -->
        <table>
            <tr>
                <td class="text-right"><strong>Total:</strong></td>
                <td class="text-right">Bs. {{ number_format($venta->monto_total, 2, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Pie de Página -->
        <footer>
            <hr>
            <p>¡Gracias por su compra!</p>
            <p>Factura generada por el sistema el {{ now()->format('d/m/Y H:i') }}</p>
        </footer>
    </div>
</body>

</html>