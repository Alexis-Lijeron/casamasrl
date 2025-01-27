<div class="d-flex">
    @include('components.plantillas.sidebar')

    <main class="flex-grow-1 p-4">
        <div class="container">
            <!-- Contenedor de búsqueda y breadcrumb en la misma fila -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Buscador -->
                <div class="search-container" style="width: 50%;">
                    <input type="text" id="search-input" class="form-control" placeholder="Buscar...">
                    <div id="search-results" class="list-group position-absolute w-100" style="z-index: 1000; display: none;"></div>
                </div>

                <!-- Navegación (Breadcrumbs) -->
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Panel Admin</a></li>
                        @if(!empty($subtitle))
                            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $title }}</a></li>
                            <li class="breadcrumb-item active">{{ $subtitle }}</li>
                        @else
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        @endif
                    </ol>
                </div>
            </div>

            <!-- Título de la Página -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ $name }}</h4>
                    </div>
                </div>
            </div>

            {{ $slot }}
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const resultsContainer = document.getElementById('search-results');

        searchInput.addEventListener('input', function () {
            let query = this.value.trim();

            if (query.length === 0) {
                resultsContainer.style.display = 'none';
                resultsContainer.innerHTML = '';
                return;
            }

            fetch(`/search?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    if (data.length === 0) {
                        resultsContainer.innerHTML = '<div class="list-group-item">No se encontraron resultados</div>';
                    } else {
                        data.forEach(item => {
                            let element = document.createElement('a');
                            element.href = item.url;
                            element.classList.add('list-group-item', 'list-group-item-action');
                            element.textContent = item.title;
                            resultsContainer.appendChild(element);
                        });
                    }
                    resultsContainer.style.display = 'block';
                })
                .catch(error => console.error('Error en la búsqueda:', error));
        });

        // Ocultar los resultados si el usuario hace clic fuera
        document.addEventListener('click', function (event) {
            if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
                resultsContainer.style.display = 'none';
            }
        });
    });
    </script>
