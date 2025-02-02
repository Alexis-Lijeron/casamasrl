<x-layouts.app>
    <x-layouts.content title="Asignar Permisos" subtitle="" name="Asignar Permisos">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="col-md-4">
                                <select class="form-control" id="select-rol">
                                    <option value="0">Seleccionar Rol</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol['id'] }}">{{ $rol['nombre'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="button" id="btn-sincronizar-todos" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i> Sincronizar todos
                                </button>
                                <button type="button" id="btn-revocar-todos" class="btn btn-danger ml-1">
                                    <i class="fas fa-times-circle"></i> Revocar todos
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            @php
                                $grupos = [
                                    'Menús Principales' => 'menu.',
                                    'Submenús' => 'submenu.',
                                    'Usuarios' => 'usuarios.',
                                    'Roles y Permisos' => ['roles.', 'permisos.'],
                                    'Productos' => 'productos.',
                                    'Categorias' => 'categorias.',
                                    'Marcas' => 'marcas.',
                                    'Clientes' => 'clientes.',
                                    'Compras' => 'compras.',
                                    'Ventas' => 'ventas.',
                                    'Reportes' => 'reportes.'
                                ];
                            @endphp
                            @foreach ($grupos as $titulo => $filtro)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0">{{ $titulo }}</h5>
                                            <div>
                                                <button type="button"
                                                    class="btn btn-sm btn-success asignar-seccion"
                                                    data-filtro="{{ is_array($filtro) ? json_encode($filtro) : $filtro }}">
                                                    <i class="fas fa-check"></i> Asignar todos
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger revocar-seccion"
                                                    data-filtro="{{ is_array($filtro) ? json_encode($filtro) : $filtro }}">
                                                    <i class="fas fa-times"></i> Revocar todos
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="w-100">
                                                @foreach ($permisos as $permiso)
                                                    @if (
                                                        (is_array($filtro) && collect($filtro)->contains(fn($f) => str_starts_with($permiso['slug'], $f))) ||
                                                        (is_string($filtro) && str_starts_with($permiso['slug'], $filtro))
                                                    )
                                                        <div class="checkbox checkbox-primary mb-2 w-100">
                                                            <input class="permiso-checkbox" id="{{ $permiso['id'] }}"
                                                                value="{{ $permiso['id'] }}" name="{{ $permiso['id'] }}"
                                                                data-permiso-id="{{ $permiso['id'] }}" data-slug="{{ $permiso['slug'] }}" type="checkbox" disabled>
                                                            <label for="{{ $permiso['id'] }}">{{ $permiso['nombre'] }}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
            const btnRevocarTodos = document.getElementById("btn-revocar-todos");
            const btnAsignarSeccion = document.querySelectorAll(".asignar-seccion");
            const btnRevocarSeccion = document.querySelectorAll(".revocar-seccion");
            let lastSelectedRolId = 0;

            selectRol.addEventListener('change', function() {
                let selectedRolId = selectRol.value;
                if (selectedRolId === '0') {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        checkbox.disabled = true;
                    });
                } else {
                    seleccionarPermisosAsignados(selectedRolId);
                    lastSelectedRolId = selectedRolId;
                }
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    const permisoId = this.getAttribute('data-permiso-id');
                    this.checked ? asignarPermiso(permisoId, lastSelectedRolId) : quitarPermiso(permisoId, lastSelectedRolId);
                });
            });

            btnSincronizarTodos.addEventListener("click", function() {
                realizarAccionEnTodos(true);
            });

            btnRevocarTodos.addEventListener("click", function() {
                realizarAccionEnTodos(false);
            });

            // Event Listeners para los botones de sección
            btnAsignarSeccion.forEach((button, index) => {
                button.addEventListener("click", function(e) {
                    realizarAccionEnSeccion(true, this);
                });
            });

            btnRevocarSeccion.forEach((button, index) => {
                button.addEventListener("click", function(e) {
                    realizarAccionEnSeccion(false, this);
                });
            });

            function realizarAccionEnSeccion(asignar, button) {
                if (lastSelectedRolId === '0') {
                    mostrarAlerta('warning', 'Atención', 'Por favor, seleccione un rol primero');
                    return;
                }

                let filtro;
                try {
                    // Intentamos parsear el filtro como JSON
                    filtro = JSON.parse(button.getAttribute('data-filtro'));
                } catch (e) {
                    // Si falla, asumimos que es un string simple
                    filtro = button.getAttribute('data-filtro');
                }

                let permisosModificados = [];

                // Iteramos sobre todos los checkboxes
                checkboxes.forEach(checkbox => {
                    const permisoId = checkbox.getAttribute('data-permiso-id');
                    // Obtenemos el slug del permiso
                    let permisoSlug = checkbox.getAttribute('data-slug') || '';

                    if (coincideFiltro(permisoSlug, filtro) && !checkbox.disabled) {
                        checkbox.checked = asignar;
                        permisosModificados.push({
                            id: permisoId,
                            checked: asignar
                        });
                    }
                });

                // Procesamos todos los permisos modificados
                Promise.all(permisosModificados.map(permiso => {
                    if (permiso.checked) {
                        return fetch("{{ route('permisos.asignarPermiso') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                rol_id: lastSelectedRolId,
                                permiso_id: permiso.id
                            })
                        });
                    } else {
                        return fetch("{{ route('permisos.desasignarPermiso') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                rol_id: lastSelectedRolId,
                                permiso_id: permiso.id
                            })
                        });
                    }
                }))
                .then(() => {
                    if (permisosModificados.length > 0) {
                        mostrarAlerta(
                            'success',
                            '¡Operación Exitosa!',
                            `Los permisos de la sección han sido ${asignar ? 'asignados' : 'revocados'} correctamente.`
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarAlerta(
                        'error',
                        'Error',
                        'Hubo un problema al procesar los permisos'
                    );
                });
            }

            function coincideFiltro(permisoSlug, filtro) {
                if (Array.isArray(filtro)) {
                    return filtro.some(f => permisoSlug.includes(f.toLowerCase()));
                }
                return permisoSlug.includes(filtro.toLowerCase());
            }

            function realizarAccionEnTodos(asignar) {
                checkboxes.forEach(checkbox => {
                    if (!checkbox.disabled) {
                        checkbox.checked = asignar;
                        asignar ? asignarPermiso2(checkbox.value, lastSelectedRolId, false) : quitarPermiso2(checkbox.value, lastSelectedRolId, false);
                    }
                });
                mostrarAlerta('success', '¡Operación Exitosa!', `Todos los permisos han sido ${asignar ? 'asignados' : 'revocados'}.`);
            }

            function seleccionarPermisosAsignados(selectedRolId) {
                obtenerPermisosAsignados(selectedRolId).then(data => {
                    checkboxes.forEach(checkbox => {
                        checkbox.disabled = false;
                        checkbox.checked = data.some(permiso => permiso.id == checkbox.value);
                    });
                });
            }

            function asignarPermiso(permisoId, rolId) {
                fetch("{{ route('permisos.asignarPermiso') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ rol_id: rolId, permiso_id: permisoId, _token: '{{ csrf_token() }}' })
                }).then(response => response.ok ? mostrarAlerta('success', '¡Permiso Asignado!', 'El permiso ha sido asignado exitosamente') : mostrarAlerta('error', 'Oops...', 'Error al asignar el permiso'));
            }

            function asignarPermiso2(permisoId, rolId) {
                fetch("{{ route('permisos.asignarPermiso') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ rol_id: rolId, permiso_id: permisoId, _token: '{{ csrf_token() }}' })
                });
            }

            function quitarPermiso(permisoId, rolId) {
                fetch("{{ route('permisos.desasignarPermiso') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ rol_id: rolId, permiso_id: permisoId, _token: '{{ csrf_token() }}' })
                }).then(response => response.ok ? mostrarAlerta('success', '¡Permiso Revocado!', 'El permiso ha sido revocado exitosamente') : mostrarAlerta('error', 'Oops...', 'Error al revocar el permiso'));
            }

            function quitarPermiso2(permisoId, rolId) {
                fetch("{{ route('permisos.desasignarPermiso') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ rol_id: rolId, permiso_id: permisoId, _token: '{{ csrf_token() }}' })
                });
            }

            function obtenerPermisosAsignados(rolId) {
                return fetch("{{ route('permisos.obtenerPermisosRol', ':rolId') }}".replace(':rolId', rolId))
                    .then(response => response.ok ? response.json() : [])
                    .catch(() => []);
            }

            function mostrarAlerta(icono, titulo, texto) {
                Swal.fire({ icon: icono, title: titulo, text: texto, timer: 3000 });
            }
        });
    </script>
    @endpush
</x-layouts.app>
