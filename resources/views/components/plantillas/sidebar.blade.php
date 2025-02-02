<nav class="sidebar p-3 d-flex flex-column">
    <!-- Toggle Sidebar Button -->
    <button class="toggle-btn" aria-label="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- User Profile Section -->
    <div class="text-center mb-4">
        <h5 class="menu-title">Bienvenido,</h5>
        <h4 class="menu-title">{{ auth()->user()->nombre_usuario }}</h4>
    </div>

    <!-- Navigation Menu -->
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if(auth()->user()->hasPermission('menu.usuarios'))
        <li class="nav-item">
            <a href="{{ route('usuarios.index') }}" class="nav-link">
                <i class="fas fa-user-cog"></i>
                <span>Usuarios</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasPermission('menu.roles-permisos'))
        <li class="nav-item dropdown">
            <a href="javascript: void(0);" class="nav-link dropdown-toggle">
                <i class="fas fa-key"></i>
                <span>Roles y Permisos</span>
            </a>
            <ul class="nav-second-level">
                @if(auth()->user()->hasPermission('submenu.roles.ver'))
                <li><a href="{{ route('roles.index') }}">Roles</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.permisos.ver'))
                <li><a href="{{ route('permisos.index') }}">Permisos</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.permisos.asignar'))
                <li><a href="{{ route('permisos.asignar') }}">Asignar Permisos</a></li>
                @endif
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasPermission('menu.clientes'))
        <li class="nav-item">
            <a href="{{ route('clientes.index') }}" class="nav-link">
                <i class="fas fa-users"></i>
                <span>Clientes</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasPermission('menu.productos'))
        <li class="nav-item dropdown">
            <a href="javascript: void(0);" class="nav-link dropdown-toggle">
                <i class="fas fa-boxes"></i>
                <span>Productos</span>
            </a>
            <ul class="nav-second-level">
                @if(auth()->user()->hasPermission('submenu.productos.ver'))
                <li><a href="{{ route('productos.index') }}">Productos</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.categorias.ver'))
                <li><a href="{{ route('categorias.index') }}">Categorías</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.promociones.ver'))
                <li><a href="{{ route('promociones.index') }}">Promociones</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.marcas.ver'))
                <li><a href="{{ route('marcas.index') }}">Marcas</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.almacenes.ver'))
                <li><a href="{{ route('almacenes.index') }}">Almacenes</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.ajustes.ver'))
                <li><a href="{{ route('ajustes.index') }}">Ajustes de Inventario</a></li>
                @endif
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasPermission('menu.proveedores'))
        <li class="nav-item">
            <a href="{{ route('proveedor.index') }}" class="nav-link">
                <i class="fas fa-truck"></i>
                <span>Proveedores</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasPermission('menu.compras'))
        <li class="nav-item dropdown">
            <a href="javascript: void(0);" class="nav-link dropdown-toggle">
                <i class="fas fa-shopping-bag"></i>
                <span>Compras</span>
            </a>
            <ul class="nav-second-level">
                @if(auth()->user()->hasPermission('submenu.compras.ver'))
                <li><a href="{{ route('compras.index') }}">Compras</a></li>
                @endif
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasPermission('menu.ventas'))
        <li class="nav-item">
            <a href="{{ route('ventas.index') }}" class="nav-link">
                <i class="fas fa-shopping-cart"></i>
                <span>Ventas</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasPermission('menu.pagos'))
        <li class="nav-item dropdown">
            <a href="javascript: void(0);" class="nav-link dropdown-toggle">
                <i class="fas fa-donate"></i>
                <span>Pagos</span>
            </a>
            <ul class="nav-second-level">
                @if(auth()->user()->hasPermission('submenu.pagos.ver'))
                <li><a href="{{ route('pagos.index') }}">Pagos</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.metodos-pago.ver'))
                <li><a href="{{ route('metodos-pago.index') }}">Metodos de pago</a></li>
                @endif
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasPermission('menu.reportes'))
        <li class="nav-item dropdown">
            <a href="javascript: void(0);" class="nav-link dropdown-toggle">
                <i class="fas fa-file-alt"></i>
                <span>Reportes</span>
            </a>
            <ul class="nav-second-level">
                @if(auth()->user()->hasPermission('submenu.reportes.ventas'))
                <li><a href="{{ route('reportes.ventas') }}">Reporte de Ventas</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.reportes.compras'))
                <li><a href="{{ route('reportes.compras') }}">Reporte de Compras</a></li>
                @endif

                @if(auth()->user()->hasPermission('submenu.reportes.pagos'))
                <li><a href="{{ route('reportes.pagos') }}">Reporte de Pagos</a></li>
                @endif
            </ul>
        </li>
        @endif
    </ul>

    <!-- Theme Selector -->
    <div class="dropdown mt-4">
        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-palette"></i>
            <span class="btn-text">Cambiar Tema</span>
        </button>
        <ul class="dropdown-menu">
            @php
            $themeOptions = [
                ['key' => 'default', 'icon' => 'circle', 'label' => 'Predeterminado'],
                ['key' => 'children', 'icon' => 'child', 'label' => 'Niños'],
                ['key' => 'youth', 'icon' => 'gamepad', 'label' => 'Jóvenes'],
                ['key' => 'adults', 'icon' => 'briefcase', 'label' => 'Adultos'],
                ['key' => 'night', 'icon' => 'moon', 'label' => 'Modo Noche']
            ];
            @endphp
            @foreach($themeOptions as $theme)
            <li>
                <a class="dropdown-item" href="#" data-theme="{{ $theme['key'] }}">
                    <i class="fas fa-{{ $theme['icon'] }}"></i> {{ $theme['label'] }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Logout Button -->
    <form method="POST" action="{{ route('auth.logout') }}" class="mt-auto">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span class="btn-text">Cerrar Sesión</span>
        </button>
    </form>
</nav>
