<x-layouts.app>
    <x-layouts.content title="Dashboard" subtitle="" name="Dashboard">
        <div class="row">

            <!-- Sección de Bienvenida -->
            <div class="col-12 mb-4">
                <div class="card p-4 shadow-sm d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            @php
                                date_default_timezone_set('America/La_Paz');
                                $hora = date('H');
                                $saludo = $hora < 12 ? 'Buenos días' : ($hora < 19 ? 'Buenas tardes' : 'Buenas noches');
                            @endphp
                            {{ $saludo }}
                        </h2>
                        <p class="text-gray-600 mt-1">Bienvenido a CASAMA SRL</p>
                    </div>
                    <div class="d-flex align-items-center text-gray-600">
                        <i class="fas fa-clock mr-2"></i>
                        <span>{{ date('H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de Estadísticas en dos columnas -->
            @php
                $cards = [
                    ['title' => 'Producción Diaria', 'value' => '5,280 L', 'icon' => 'fas fa-milk-carton', 'color' => 'blue', 'change' => '↑ 12% vs ayer'],
                    ['title' => 'Eficiencia', 'value' => '94%', 'icon' => 'fas fa-chart-line', 'color' => 'green', 'change' => '↑ 2% esta semana'],
                    ['title' => 'Personal Activo', 'value' => '45', 'icon' => 'fas fa-users', 'color' => 'purple', 'change' => 'de 48 empleados'],
                    ['title' => 'Líneas Activas', 'value' => '4/5', 'icon' => 'fas fa-industry', 'color' => 'orange', 'change' => 'En producción']
                ];
            @endphp
            @foreach($cards as $card)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 p-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 class="text-sm font-medium text-gray-700">{{ $card['title'] }}</h3>
                            <i class="{{ $card['icon'] }} text-{{ $card['color'] }} text-lg"></i>
                        </div>
                        <div class="text-2xl font-bold text-{{ $card['color'] }}">{{ $card['value'] }}</div>
                        <p class="text-xs text-gray-600">{{ $card['change'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-layouts.content>
</x-layouts.app>
