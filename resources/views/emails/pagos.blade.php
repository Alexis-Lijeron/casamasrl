<x-layouts.app>

    <x-layouts.content title="Reportes" subtitle="Enviar correo" name="Reportes">

        <div class="row mb-5">
            <div class="col-12">

                <div class="card-box">
                    <h3 class="text-center mb-2">Enviar Correo Electrónico</h3>
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('reportes.enviar.pagos') }}" method="POST" enctype="multipart/form-data"
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
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Introduzca el asunto"
                                required>
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
    <script src="https://cdn.tiny.cloud/1/zlwkclgpr7krkcbvdkn2ui32m7hopg7xnck0xcki3lheojaa/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#message'
        });
    </script>
    <script>
        const data = @json($data);

        console.log(data);

        // Crear la tabla HTML como cadena
        let tableHtml = '<table border="1" style="border-collapse: collapse;">';
        tableHtml += '<thead><tr><th>ID</th><th>Fecha</th><th>Usuario</th><th>Cliente</th><th>Estado</th><th>Metodo Pago</th><th>Monto</th></tr></thead>';
        tableHtml += '<tbody>';
        data.forEach(pago => {
            tableHtml += `<tr>
              <td class="align-middle">${pago.id}</td>
              <td class="align-middle">${pago.fecha_pago}</td>
              <td class="align-middle">${pago.nota_venta.usuario.nombre} ${pago.nota_venta.usuario.apellido}</td>
              <td class="align-middle">${pago.nota_venta.cliente.nombre} ${pago.nota_venta.cliente.apellido}</td>
              <td class="align-middle">${pago.estado ? 'Pagado' : 'Pendiente'}</td>
              <td class="align-middle">${pago.metodo_pago?.nombre ?? 'No asignado'}</td>
              <td class="align-middle">Bs. ${pago.monto}</td>
          </tr>`;
        });
        tableHtml += '</tbody></table>';

        // Asignar la tabla HTML al campo <textarea>
        document.getElementById('message').value = tableHtml;
    </script>
    @endpush

</x-layouts.app>