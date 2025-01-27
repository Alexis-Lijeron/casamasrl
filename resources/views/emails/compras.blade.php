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
                    <form action="{{ route('reportes.enviar.compras') }}" method="POST" enctype="multipart/form-data"
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
            // Inicializar TinyMCE en el selector
            tinymce.init({
                selector: '#message'
            });

            // Obtener los datos de compras
            const data = @json($data);

            // Crear la tabla HTML como cadena
            let tableHtml = '<table border="1" style="border-collapse: collapse;">';
            tableHtml += '<thead><tr><th>ID</th><th>Fecha</th><th>Usuario</th><th>Proveedor</th><th>Producto</th><th>Categoría</th><th>Monto</th></tr></thead>';
            tableHtml += '<tbody>';

            // Recorrer los datos y construir las filas de la tabla
            data.forEach(compra => {
                tableHtml += `
                <tr>
                    <td class="align-middle">${compra.id}</td>
                    <td class="align-middle">${compra.fecha_compra}</td>
                    <td class="align-middle">${compra.usuario.nombre} ${compra.usuario.apellido}</td>
                    <td class="align-middle">${compra.proveedor.nombre_empresa} ${compra.proveedor.nombre_encargado}</td>
                    <td class="align-middle">
                        <ul>
                            ${compra.productos_almacen.map(producto => `<li>${producto.producto.nombre}</li>`).join('')}
                        </ul>
                    </td>
                    <td class="align-middle">
                        <ul>
                            ${compra.productos_almacen.map(producto => `<li>${producto.producto.categoria.nombre}</li>`).join('')}
                        </ul>
                    </td>
                    <td class="align-middle">Bs. ${compra.monto_total}</td>
                </tr>`;
            });

            tableHtml += '</tbody></table>';

            // Asignar la tabla HTML al campo <textarea> para que TinyMCE la pueda renderizar
            const messageTextarea = document.getElementById('message');
            if (messageTextarea) {
                messageTextarea.value = tableHtml;
            }
        });
    </script>
    @endpush

</x-layouts.app>