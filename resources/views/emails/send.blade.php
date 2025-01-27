<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Correo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/zlwkclgpr7krkcbvdkn2ui32m7hopg7xnck0xcki3lheojaa/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#message'
        });
    </script>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Enviar Correo Electrónico</h2>
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('send.email') }}" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm bg-white rounded">
            @csrf
            <div class="mb-3">
                <label for="to" class="form-label">Destinatarios:</label>
                <input type="text" name="to" id="to" class="form-control" placeholder="Introduzca los emails separados por coma" required>
                <small id="emailHelp" class="form-text text-muted">Ejemplo: ejemplo1@gmail.com, ejemplo2@gmail.com</small>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Asunto:</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Introduzca el asunto" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Mensaje:</label>
                <textarea id="message" name="message"></textarea>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Adjuntar Archivos:</label>
                <input type="file" name="attachment[]" id="attachment" multiple class="form-control">
                <small id="fileHelp" class="form-text text-muted">Puede adjuntar múltiples archivos.</small>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar Correo</button>
        </form>
    </div>
</body>

</html>