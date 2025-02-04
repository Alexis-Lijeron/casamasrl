<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CASAMA SRL</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/images/lego.jpg') }}" type="image/x-icon" />

    <!-- Custom Theme CSS -->
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" type="text/css">

    <!-- External Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    @stack('styles')
</head>

<body class="antialiased">
    {{ $slot }}

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme Manager -->
    <script src="{{ asset('js/theme-manager.js') }}"></script>

    @if(session('guardado'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Guardado!',
            text: '{{ session('
            guardado ') }}',
            timer: 3000
        });
    </script>
    @endif

    @if(session('actualizado'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Actualizado!',
            text: '{{ session('
            actualizado ') }}',
            timer: 3000
        });
    </script>
    @endif

    @if(session('eliminado'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Eliminado!',
            text: '{{ session('
            eliminado ') }}',
            timer: 3000
        });
    </script>
    @endif

    @if(session('confirmado'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Confirmado!',
            text: '{{ session('
            confirmado ') }}',
            timer: 3000
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('
            error ') }}',
            timer: 3000
        });
    </script>
    @endif

    @if (session('accesoDenegado'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: '¡Acceso Denegado!',
            text: 'No tiene los permisos necesarios.',
            timer: 3000
        })
    </script>
    @endif

    @if(session('enviado'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Enviado!',
            text: '{{ session('
            enviado ') }}',
            timer: 3000
        });
    </script>
    @endif
    @stack('js')
</body>
<footer class="text-center mt-4">
    <p>Esta página ha sido visitada {{ $visitCount ?? 0 }} veces.</p>
</footer>

</html>