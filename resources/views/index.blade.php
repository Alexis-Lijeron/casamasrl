<x-layouts.app>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <a href="">
                                <span><img src="{{ asset('/images/lego.jpg') }}" alt="" height="150"></span>
                            </a>
                            <h2 class="mb-4 mt-2 text-uppercase font-weight-bold"
                                style="color: #1a1a1a; user-select: none;">
                                <span style="color: #1f3fe1">CASAMA</span> SRL
                            </h2>
                        </div>

                        <h5 class="auth-title">Iniciar Sesión</h5>

                        {{-- Mostrar mensajes de bloqueo o errores --}}
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @error('login_invalid')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <form method="POST" action="{{ route('auth.login') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="email">Correo Electrónico:</label>
                                <input class="form-control" name="email" type="text" id="email"
                                    value="{{ old('email') }}" placeholder="Ingrese su correo electrónico" autofocus>
                                @error('email')
                                <span class="error text-danger">* {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-1">
                                <label for="password">Contraseña:</label>
                                <input class="form-control" name="password" type="password" id="password"
                                    placeholder="Ingrese su contraseña">
                                @error('password')
                                <span class="error text-danger">* {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="col-12 text-right">
                                    <p><a href="#" class="text-muted ml-1">¿Olvidaste tu contraseña?</a></p>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-dark btn-block" type="submit"> INGRESAR </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('js')


    @endpush

</x-layouts.app>
