<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <ul class="metismenu" id="side-menu">

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li>
                <a href="{{route('usuarios.index')}}">
                    <i class="fas fa-user-cog"></i>
                    <span> Usuarios </span>
                </a>
            </li>

            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-key"></i>
                    <span> Roles y Permisos </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('roles.index')}}">Roles</a>
                    </li>
                    <li>
                        <a href="{{ route('permisos.index') }}">Permisos</a>
                    </li>
                    <li>
                        <a href="{{ route('permisos.asignar') }}">Asignar Permisos</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('clientes.index') }}">
                    <i class="fas fa-users"></i>
                    <span> Clientes </span>
                </a>
            </li>
            
            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-boxes"></i>
                    <span> Productos </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('productos.index') }}">Productos</a>
                    </li>
                    <li>
                        <a href="{{ route('categorias.index') }}">Categorías</a>
                    </li>
                    <li>
                        <a href="{{ route('marcas.index') }}">Marcas</a>
                    </li>
                    <li>
                        <a href="{{ route('almacenes.index') }}">Almacenes</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('proveedor.index') }}">
                    <i class="fas fas fa-truck"></i>
                    <span> Proveedores </span>
                </a>
            </li>

            {{-- <li>
                <a href="{{ route('compras.index') }}">
                    <i class="fas fa-shopping-bag"></i>
                    <span> Compras </span>
                </a>
            </li> --}}
            
            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-shopping-bag"></i>
                    <span> Compras </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('compras.index') }}">Compras</a>
                    </li>
                    <li>
                        <a href="{{ route('devoluciones.index') }}">Devoluciones</a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="{{ route('ventas.index')}}">
                    <i class="fas fa-shopping-cart"></i>
                    <span> Ventas </span>
                </a>
            </li>

            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-donate"></i>
                    <span> Pagos </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('pagos.index') }}">Pagos</a>
                    </li>
                    <li>
                        <a href="{{route('metodos-pago.index')}}">Metodos de pago</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);">
                    <i class="fas fa-file-alt"></i>
                    <span> Reportes </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('reportes.ventas') }}">Reporte de Ventas</a>
                    </li>
                    <li>
                        <a href="{{ route('reportes.compras') }}">Reporte de Compras</a>
                    </li>
                    <li>
                        <a href="{{ route('reportes.pagos') }}">Reporte de Pagos</a>
                    </li>
                </ul>
            </li>

        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->