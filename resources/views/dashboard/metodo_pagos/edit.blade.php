<x-layouts.app>

    <x-layouts.content title="Metodos de Pago" subtitle="Editar metodo de pago" name="Metodos de Pago">

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-pencil-alt fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Editar metodo de pago</h3>
                    </div>

                    <form class="px-4 pt-2 pb-2" action="{{ route('metodos-pago.update', $metodo['id']) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Ej: Tarjeta de credito"
                                        value="{{ old('nombre', $metodo['nombre']) }}" >
                                    @error('nombre')
                                        <span class="error text-danger">* {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group m-b-0">
                            <a href="{{ route('metodos-pago.index') }}" class="btn btn-danger waves-effect m-l-5">
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

</x-layouts.app>
