<div>
    <h2>Reporte de Usuarios</h2>
    <p>Este es un reporte de los usuarios registrados en la aplicación.</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>