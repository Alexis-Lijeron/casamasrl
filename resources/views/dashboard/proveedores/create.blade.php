<x-layouts.app>

    <x-layouts.content title="Proveedores" subtitle="Crear proveedor" name="Proveedores">

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-user-plus fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Crear nuevo proveedor</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{ route('proveedor.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre_empresa" class="control-label">Nombre de la Empresa</label>
                                    <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa"
                                        placeholder="Ej: Empresa XYZ" value="{{ old('nombre_empresa') }}" >
                                    @error('nombre_empresa')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre_encargado" class="control-label">Nombre del Encargado</label>
                                    <input type="text" class="form-control" id="nombre_encargado" name="nombre_encargado"
                                        placeholder="Ej: Jhon Doe" value="{{ old('nombre_encargado') }}">
                                    @error('nombre_encargado')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Ej: jhondoe@gmail.com" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono" class="control-label">Telefono</label>
                                    <input type="number" min="0" class="form-control" id="telefono" name="telefono"
                                        placeholder="Ej: 77664412" value="{{ old('telefono') }}">
                                    @error('telefono')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion" class="control-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion"
                                        placeholder="Ej: Calle #123" value="{{ old('direccion') }}">
                                    @error('direccion')
                                    <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right m-b-0">
                            <a href="{{ route('proveedor.index') }}" class="btn btn-danger waves-effect m-l-5">
                                Cancelar
                            </a>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                Guardar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </x-layouts.content>

</x-layouts.app>
