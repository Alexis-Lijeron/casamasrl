<x-layouts.app>
    <x-layouts.content title="Usuarios" subtitle="Editar usuario" name="Usuarios">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-pencil-alt fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Editar Usuario</h3>
                    </div>
                    <form class="px-4 pt-2 pb-2" action="{{ route('usuarios.update', $usuario->id) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Jhon" value="{{ old('nombre', $usuario->nombre) }}">
                                    @error('nombre')
                                        <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellido" class="control-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Doe" value="{{ old('apellido', $usuario->apellido) }}">
                                    @error('apellido')
                                        <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="jhondoe@gmail.com" value="{{ old('email', $usuario->email) }}">
                                    @error('email')
                                        <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono" class="control-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="77445318" value="{{ old('telefono', $usuario->telefono) }}">
                                    @error('telefono')
                                        <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="control-label">Contraseña (opcional)</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="********">
                                    <small class="form-text text-muted">
                                        La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un carácter especial o número.
                                    </small>
                                    @error('password')
                                        <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="roles" class="control-label">Roles</label>
                                    <select class="form-control select2" id="roles" name="roles[]" multiple>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}" {{ in_array($rol->id, old('roles', $usuario->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $rol->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right m-b-0">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-danger waves-effect m-l-5">
                                Cancelar
                            </a>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-layouts.content>
    @push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Seleccione un rol",
                allowClear: true
            }).val(@json($usuario->roles->pluck('id'))).trigger('change');
        });
    </script>
    @endpush
</x-layouts.app>
