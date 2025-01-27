<x-layouts.app>

    <x-layouts.content title="Reportes" subtitle="Enviar correo" name="Reportes">

        <div class="row">
            <div class="col-12">

                <div class="card-box">
                    <h3 class="text-center mb-2">Enviar Correo Electrónico</h3>
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('reportes.enviar.ventas') }}" method="POST" enctype="multipart/form-data"
                        class="px-4 mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="to" class="form-label">Destinatarios:</label>
                            <input type="text" name="to" id="to" class="form-control"
                                placeholder="Introduzca los emails separados por coma" required>
                            <small id="emailHelp" class="form-text text-muted">Ejemplo: ejemplo1@gmail.com,
                                ejemplo2@gmail.com</small>
                            @error('to')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Asunto:</label>
                            <input type="text" name="subject" id="subject" class="form-control"
                                placeholder="Introduzca el asunto" required>
                            @error('subject')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Mensaje:</label>
                            <textarea id="message" name="message" required></textarea>
                            <input type="hidden" name="content" value="{{ json_encode($data) }}">
                            @error('message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="attachment" class="form-label">Adjuntar Archivos:</label>
                            <input type="file" name="attachment[]" id="attachment" multiple class="form-control">
                            <small id="fileHelp" class="form-text text-muted">Puede adjuntar múltiples
                                archivos.</small>
                        </div> --}}
                        <button type="submit" class="btn btn-primary w-100">Enviar Correo</button>
                    </form>

                </div>
            </div>
        </div>

    </x-layouts.content>

    @push('js')
    <script src="https://cdn.tiny.cloud/1/zlwkclgpr7krkcbvdkn2ui32m7hopg7xnck0xcki3lheojaa/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar TinyMCE
            tinymce.init({
                selector: '#message'
            });

            // Obtener los datos desde el backend
            const data = @json($data);

            // Crear la tabla HTML como cadena
            let tableHtml = `
            <table border="1" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
        `;

            // Generar las filas de la tabla con los datos
            data.forEach(venta => {
                tableHtml += `
                <tr>
                    <td class="align-middle">${venta.id}</td>
                    <td class="align-middle">${venta.fecha_venta}</td>
                    <td class="align-middle">${venta.usuario.nombre} ${venta.usuario.apellido}</td>
                    <td class="align-middle">${venta.cliente.nombre} ${venta.cliente.apellido}</td>
                    <td class="align-middle">
                        <ul>
                            ${venta.productos_almacen.map(producto => `<li>${producto.producto.nombre}</li>`).join('')}
                        </ul>
                    </td>
                    <td class="align-middle">
                        <ul>
                            ${venta.productos_almacen.map(producto => `<li>${producto.producto.categoria.nombre}</li>`).join('')}
                        </ul>
                    </td>
                    <td class="align-middle">Bs. ${venta.monto_total}</td>
                </tr>
            `;
            });

            tableHtml += `
                </tbody>
            </table>
        `;

            // Asignar la tabla HTML al campo <textarea>
            const messageField = document.getElementById('message');
            if (messageField) {
                messageField.value = tableHtml;
            }
        });
    </script>
    @endpush


</x-layouts.app>