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
                                                                data-permiso-id="{{ $permiso['id'] }}" type="checkbox" disabled>
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

            function quitarPermiso(permisoId, rolId) {
                fetch("{{ route('permisos.desasignarPermiso') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ rol_id: rolId, permiso_id: permisoId, _token: '{{ csrf_token() }}' })
                }).then(response => response.ok ? mostrarAlerta('success', '¡Permiso Revocado!', 'El permiso ha sido revocado exitosamente') : mostrarAlerta('error', 'Oops...', 'Error al revocar el permiso'));
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
