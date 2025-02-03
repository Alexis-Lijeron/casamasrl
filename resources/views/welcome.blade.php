<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('CASAMA SRL', 'CASAMA SRL') }}</title>
    <link rel="shortcut icon" href="{{ asset('/images/lego.jpg') }}" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-white text-gray-900 font-sans">
    <header class="fixed w-full z-20 top-0 start-0 bg-white border-b border-gray-200">
        <nav class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/lego.jpg') }}" class="h-10" alt="Logo de Lácteos">
                <span class="self-center text-2xl font-semibold whitespace-nowrap">CASAMA SRL</span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                @if (Route::has('auth.login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('auth.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center ml-2">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main class="pt-20">
        <section class="bg-white">
            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div class="mr-auto place-self-center lg:col-span-7">
                    <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl">
                        Productos Lácteos Frescos y de Calidad
                    </h1>
                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl">
                        Descubre la pureza y frescura de nuestros productos lácteos. Desde leche fresca hasta quesos artesanales, cada producto cuenta con nuestro compromiso de calidad.
                    </p>
                    <a href="#productos" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                        Ver Productos
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
                <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                    <img src="{{ asset('images/dairy-hero-image.jpg') }}" alt="Productos Lácteos">
                </div>
            </div>
        </section>

        <section id="productos" class="bg-gray-50 py-16">
            <div class="max-w-screen-xl mx-auto px-4">
                <h2 class="text-3xl font-extrabold text-center mb-12">Nuestros Productos</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <img class="w-32 h-32 object-cover mx-auto mb-4" src="{{ asset('images/milk-image.jpg') }}" alt="Leche">
                        <h3 class="text-xl font-semibold mb-2">Leche Fresca</h3>
                        <p class="text-gray-600">Leche 100% natural, pasteurizada y de origen local.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <img class="w-32 h-32 object-cover mx-auto mb-4" src="{{ asset('images/cheese-image.jpg') }}" alt="Quesos">
                        <h3 class="text-xl font-semibold mb-2">Quesos Artesanales</h3>
                        <p class="text-gray-600">Quesos elaborados con técnicas tradicionales y productos de primera.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <img class="w-32 h-32 object-cover mx-auto mb-4" src="{{ asset('images/yogurt-image.jpg') }}" alt="Yogurt">
                        <h3 class="text-xl font-semibold mb-2">Yogurt Natural</h3>
                        <p class="text-gray-600">Yogurt sin conservantes, rico en probióticos y sabor.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t">
        <div class="max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="{{ url('/') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('images/logo.svg') }}" class="h-8" alt="Logo de Lácteos">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap">CASAMA SRL</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                    <li><a href="#" class="hover:underline me-4 md:me-6">Nosotros</a></li>
                    <li><a href="#" class="hover:underline me-4 md:me-6">Contacto</a></li>
                    <li><a href="#" class="hover:underline">Política de Privacidad</a></li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center">© {{ date('Y') }} CASAMA SRL. Todos los derechos reservados.</span>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>
</html>
