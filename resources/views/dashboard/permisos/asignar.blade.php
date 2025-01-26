<x-layouts.app>

    <x-layouts.content title="Asignar Permisos" subtitle="" name="Asignar Permisos">

        <div class="row">
            <div class="col-12">

                <div class="card-box">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-4">
                            <select class="form-control" id="select-rol">
                                <option value="0">Seleccionar Rol</option>
                                @foreach ($roles as $rol)
                                <option value="{{ $rol['id'] }}">{{ $rol['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="d-flex">
                                <button type="button" id="btn-sincronizar-todos" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i>&nbsp;
                                    Sincronizar todos
                                </button>

                                <button type="button" id="btn-revocar-todos" class="btn btn-danger ml-1">
                                    <i class="fas fa-times-circle"></i>&nbsp;
                                    Revocar todos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-asignar-permiso" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">Permiso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permisos as $permiso)
                                <tr class="text-nowrap text-center">
                                    <th scope="row" style="width: 100px" class="align-middle">{{ $permiso['id'] }}</th>
                                    <td class="align-middle">
                                        <div class="checkbox checkbox-primary">
                                            <input class="permiso-checkbox" id="{{ $permiso['id'] }}"
                                                value="{{ $permiso['id'] }}" name="{{ $permiso['id'] }}"
                                                data-permiso-id="{{ $permiso['id'] }}" type="checkbox" disabled>
                                            <label for="{{ $permiso['id'] }}">
                                                {{ $permiso['nombre'] }}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </x-layouts.content>

    @push('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                const selectRol = document.getElementById('select-rol');
                const checkboxes = document.querySelectorAll('.permiso-checkbox');
                const btnSincronizarTodos = document.getElementById("btn-sincronizar-todos");
                const btnRevocarTodos = document.getElementById("btn-revocar-todos");;
                let lastSelectedRolId = 0;

                selectRol.addEventListener('change', function() {
                    var selectedRolId = selectRol.value;

                    if (selectedRolId === '0') {
                        // Si no se selecciona un rol, deshabilitar los checkboxes
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = false;
                            checkbox.disabled = true;
                        });
                    } else {
                        seleccionarPermisosAsignados(selectedRolId);

                        // Deseleccionar los checkboxes si se cambia el rol
                        if (selectedRolId !== lastSelectedRolId) {
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });
                        }

                        // Actualizar el último rol seleccionado
                        lastSelectedRolId = selectedRolId;
                    }
                });

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('click', function() {
                        const permisoId = this.getAttribute('data-permiso-id');
                        const isChecked = this.checked;

                        if (isChecked) {
                            // Llama a una función que asigna el permiso al rol
                            asignarPermiso(permisoId, lastSelectedRolId);
                        } else {
                            // Llama a una función que quita el permiso del rol si es necesario
                            quitarPermiso(permisoId, lastSelectedRolId);
                        }
                    });
                });

                function seleccionarPermisosAsignados(selectedRolId) {
                    obtenerPermisosAsignados(selectedRolId)
                            .then(data => {
                                checkboxes.forEach(function (checkbox) {
                                    checkbox.disabled = false;
                                    const permisoId = checkbox.value;
                                    const permisoAsignado = data.some(permiso => permiso.id == permisoId);
                                    checkbox.checked = permisoAsignado;
                                });
                            })
                            .catch(err => {
                                console.error("Error al obtener permisos:", err);
                            });
                }

                function asignarPermiso(permisoId, rolId) {
                    // Realiza una solicitud POST a la API para asignar el permiso al rol
                    const url = "{{ route('permisos.asignarPermiso') }}";
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            rol_id: rolId,
                            permiso_id: permisoId,
                            _token: '{{ csrf_token() }}'
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            mostrarAlerta('error', 'Oops...', 'Error al asignar el permiso');
                            throw new Error('Error al asignar el permiso');
                        }
                        mostrarAlerta('success', '¡Permiso Asignado!', 'El permiso ha sido asignado exitosamente');
                        return response.json();
                    })
                    .then(data => {
                        // Maneja la respuesta exitosa, por ejemplo, muestra un mensaje al usuario
                        console.log(data.message);
                    })
                    .catch(error => {
                        // Maneja errores, por ejemplo, muestra un mensaje de error al usuario
                        console.error(error);
                    });
                }

                function quitarPermiso(permisoId, rolId) {
                    // Realiza una solicitud POST a la API para asignar el permiso al rol
                    const url = "{{ route('permisos.desasignarPermiso') }}";
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            rol_id: rolId,
                            permiso_id: permisoId,
                            _token: '{{ csrf_token() }}'
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            mostrarAlerta('error', 'Oops...', 'Error al revocar el permiso');
                            throw new Error('Error al revocar el permiso');
                        }
                        mostrarAlerta('success', '¡Permiso Revocado!', 'El permiso ha sido revocado exitosamente');
                        return response.json();
                    })
                    .then(data => {
                        // Maneja la respuesta exitosa, por ejemplo, muestra un mensaje al usuario
                        console.log(data.message);
                    })
                    .catch(error => {
                        // Maneja errores, por ejemplo, muestra un mensaje de error al usuario
                        console.error(error);
                    });
                }

                function obtenerPermisosAsignados(rolId) {
                    // const url = `/permisos/obtenerPermisosRol/${rolId}`;
                    const url = "{{ route('permisos.obtenerPermisosRol', ':rolId') }}".replace(':rolId', rolId);

                    return fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Error en la solicitud");
                            }
                            return response.json();
                        })
                        .catch(error => {
                            console.error("Error al obtener permisos:", error);
                            return [];
                        });
                }

                btnSincronizarTodos.addEventListener("click", function (event) {
                    event.preventDefault();

                    const rolId = selectRol.value;

                    // Verifica si se ha seleccionado un rol válido
                    if (rolId !== "0") {
                        // Envía una solicitud al servidor API para asignar todos los permisos al rol
                        const url = "{{ route('permisos.asignarTodosLosPermisos', ':rolId') }}".replace(':rolId', rolId);
                        fetch(url, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                            },
                        })
                            .then((response) => {
                                if (response.ok) {
                                    seleccionarPermisosAsignados(rolId);
                                    mostrarAlerta('success', '¡Permisos Asignados!', 'Los permisos han sido sincronizados exitosamente');
                                } else {
                                    mostrarAlerta('error', 'Oops...', 'Error al sincronizar los permisos');
                                }
                            })
                            .catch((error) => {
                                console.error(error);
                                alert("Error al asignar permisos.");
                            });
                    } else {
                        mostrarAlerta('info', 'Oops...', 'Debes seleccionar un rol válido antes de sincronizar los permisos');
                    }
                });

                btnRevocarTodos.addEventListener("click", function (event) {
                    event.preventDefault();

                    const rolId = selectRol.value;

                    // Verifica si se ha seleccionado un rol válido
                    if (rolId !== "0") {
                        // Envía una solicitud al servidor API para asignar todos los permisos al rol
                        const url = "{{ route('permisos.desasignarTodosLosPermisos', ':rolId') }}".replace(':rolId', rolId);
                        fetch(url, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                            },
                        })
                            .then((response) => {
                                if (response.ok) {
                                    seleccionarPermisosAsignados(rolId);
                                    mostrarAlerta('success', '¡Permisos Revocados!', 'Los permisos han sido revocados exitosamente');
                                } else {
                                    mostrarAlerta('error', 'Oops...', 'Error al revocar los permisos');
                                }
                            })
                            .catch((error) => {
                                console.error(error);
                                alert("Error al revocar permisos.");
                            });
                    } else {
                        mostrarAlerta('info', 'Oops...', 'Debes seleccionar un rol válido antes de revocar permisos');
                    }
                });
            });
            
        function mostrarAlerta(icono, titulo, texto, tiempo = 3000) {
            Swal.fire({
                icon: icono,
                title: titulo,
                text: texto,
                timer: tiempo,
            });
        }
    </script>
    @endpush

</x-layouts.app>