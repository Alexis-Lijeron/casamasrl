<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AjusteInventarioController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PromocionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('auth.index');
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout')->name('auth.logout');
});

// Rutas protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // ------------------ RUTAS DE ROLES ------------------
    Route::middleware(['permission:roles.listar'])->group(function () {
        Route::controller(RolController::class)->group(function () {
            Route::get('/roles', 'index')->name('roles.index');
            Route::get('/roles/create', 'create')->middleware('permission:roles.crear')->name('roles.create');
            Route::get('/roles/show/{id}', 'show')->name('roles.show');
            Route::get('/roles/edit/{id}', 'edit')->middleware('permission:roles.editar')->name('roles.edit');
            Route::post('/roles', 'store')->middleware('permission:roles.crear')->name('roles.store');
            Route::post('/roles/update/{id}', 'update')->middleware('permission:roles.editar')->name('roles.update');
            Route::post('/roles/delete/{id}', 'destroy')->middleware('permission:roles.eliminar')->name('roles.delete');
        });
    });

    // Gestión de Permisos
    Route::middleware(['permission:permisos.listar'])->group(function () {
        Route::controller(PermisoController::class)->group(function () {
            Route::get('/permisos', 'index')->name('permisos.index');
            Route::get('/permisos/asignar', 'asignar')->middleware('permission:permisos.asignar')->name('permisos.asignar');
            Route::get('/permisos/obtenerPermisosRol/{rol_id}', 'obtenerPermisosRol')->name('permisos.obtenerPermisosRol');
            Route::post('/permisos/asignarPermiso', 'asignarPermiso')->middleware('permission:permisos.asignar')->name('permisos.asignarPermiso');
            Route::post('/permisos/desasignarPermiso', 'desasignarPermiso')->middleware('permission:permisos.asignar')->name('permisos.desasignarPermiso');
            Route::post('/permisos/asignarTodosLosPermisos/{rol_id}', 'asignarTodosLosPermisos')->middleware('permission:permisos.asignar')->name('permisos.asignarTodosLosPermisos');
            Route::post('/permisos/desasignarTodosLosPermisos/{rol_id}', 'desasignarTodosLosPermisos')->middleware('permission:permisos.asignar')->name('permisos.desasignarTodosLosPermisos');
        });
    });

    // Gestión de Usuarios
    Route::middleware(['permission:usuarios.listar'])->group(function () {
        Route::controller(UsuarioController::class)->group(function () {
            Route::get('/usuarios', 'index')->name('usuarios.index');
            Route::get('/usuarios/create', 'create')->middleware('permission:usuarios.crear')->name('usuarios.create');
            Route::get('/usuarios/show/{id}', 'show')->name('usuarios.show');
            Route::post('/usuarios', 'store')->middleware('permission:usuarios.crear')->name('usuarios.store');
            Route::post('/usuarios/update/{id}', 'update')->middleware('permission:usuarios.editar')->name('usuarios.update');
            Route::post('/usuarios/delete/{id}', 'destroy')->middleware('permission:usuarios.eliminar')->name('usuarios.delete');
        });
    });

    // Gestión de Clientes
    Route::middleware(['permission:clientes.listar'])->group(function () {
        Route::controller(ClienteController::class)->group(function () {
            Route::get('/clientes', 'index')->name('clientes.index');
            Route::get('/clientes/create', 'create')->middleware('permission:clientes.crear')->name('clientes.create');
            Route::get('/clientes/edit/{id}', 'edit')->middleware('permission:clientes.editar')->name('clientes.edit');
            Route::get('/clientes/show/{id}', 'show')->name('clientes.show');
            Route::post('/clientes', 'store')->middleware('permission:clientes.crear')->name('clientes.store');
            Route::post('/clientes/update/{id}', 'update')->middleware('permission:clientes.editar')->name('clientes.update');
            Route::post('/clientes/delete/{id}', 'destroy')->middleware('permission:clientes.eliminar')->name('clientes.delete');
        });
    });

    // Gestión de Categorías
    Route::middleware(['permission:categorias.listar'])->group(function () {
        Route::controller(CategoriaController::class)->group(function () {
            Route::get('/categorias', 'index')->name('categorias.index');
            Route::get('/categorias/create', 'create')->middleware('permission:categorias.crear')->name('categorias.create');
            Route::get('/categorias/edit/{id}', 'edit')->middleware('permission:categorias.editar')->name('categorias.edit');
            Route::post('/categorias', 'store')->middleware('permission:categorias.crear')->name('categorias.store');
            Route::post('/categorias/update/{id}', 'update')->middleware('permission:categorias.editar')->name('categorias.update');
            Route::post('/categorias/delete/{id}', 'destroy')->middleware('permission:categorias.eliminar')->name('categorias.delete');
        });
    });

    // Gestión de Marcas
    Route::middleware(['permission:marcas.listar'])->group(function () {
        Route::controller(MarcaController::class)->group(function () {
            Route::get('/marcas', 'index')->name('marcas.index');
            Route::get('/marcas/create', 'create')->middleware('permission:marcas.crear')->name('marcas.create');
            Route::get('/marcas/show/{id}', 'show')->name('marcas.show');
            Route::get('/marcas/edit/{id}', 'edit')->middleware('permission:marcas.editar')->name('marcas.edit');
            Route::post('/marcas', 'store')->middleware('permission:marcas.crear')->name('marcas.store');
            Route::post('/marcas/update/{id}', 'update')->middleware('permission:marcas.editar')->name('marcas.update');
            Route::post('/marcas/delete/{id}', 'destroy')->middleware('permission:marcas.eliminar')->name('marcas.delete');
        });
    });

    // Gestión de Almacenes
    Route::middleware(['permission:almacenes.listar'])->group(function () {
        Route::controller(AlmacenController::class)->group(function () {
            Route::get('/almacenes', 'index')->name('almacenes.index');
            Route::get('/almacenes/create', 'create')->middleware('permission:almacenes.crear')->name('almacenes.create');
            Route::get('/almacenes/show/{id}', 'show')->name('almacenes.show');
            Route::get('/almacenes/edit/{id}', 'edit')->middleware('permission:almacenes.editar')->name('almacenes.edit');
            Route::post('/almacenes', 'store')->middleware('permission:almacenes.crear')->name('almacenes.store');
            Route::post('/almacenes/update/{id}', 'update')->middleware('permission:almacenes.editar')->name('almacenes.update');
            Route::post('/almacenes/delete/{id}', 'destroy')->middleware('permission:almacenes.eliminar')->name('almacenes.delete');
        });
    });

        Route::controller(MetodoPagoController::class)->group(function () {
            Route::get('/metodos-pago', 'index')->name('metodos-pago.index');
            Route::get('/metodos-pago/create', 'create')->name('metodos-pago.create');
            Route::get('/metodos-pago/edit/{id}', 'edit')->name('metodos-pago.edit');
            Route::post('/metodos-pago', 'store')->name('metodos-pago.store');
            Route::post('/metodos-pago/update/{id}', 'update')->name('metodos-pago.update');
            Route::post('/metodos-pago/delete/{id}', 'destroy')->name('metodos-pago.delete');
        });

    // Gestión de Proveedores
    Route::middleware(['permission:proveedores.listar'])->group(function () {
        Route::controller(ProveedorController::class)->group(function () {
            Route::get('/proveedor', 'index')->name('proveedor.index');
            Route::get('/proveedor/create', 'create')->middleware('permission:proveedores.crear')->name('proveedor.create');
            Route::get('/proveedor/edit/{id}', 'edit')->middleware('permission:proveedores.editar')->name('proveedor.edit');
            Route::post('/proveedor', 'store')->middleware('permission:proveedores.crear')->name('proveedor.store');
            Route::post('/proveedor/update/{id}', 'update')->middleware('permission:proveedores.editar')->name('proveedor.update');
            Route::post('/proveedor/delete/{id}', 'destroy')->middleware('permission:proveedores.eliminar')->name('proveedor.delete');
        });
    });

    // Gestión de Productos
    Route::middleware(['permission:productos.listar'])->group(function () {
        Route::controller(ProductoController::class)->group(function () {
            Route::get('/productos', 'index')->name('productos.index');
            Route::get('/productos/create', 'create')->middleware('permission:productos.crear')->name('productos.create');
            Route::get('/productos/edit/{id}', 'edit')->middleware('permission:productos.editar')->name('productos.edit');
            Route::get('/productos/show/{id}', 'show')->name('productos.show');
            Route::post('/productos', 'store')->middleware('permission:productos.crear')->name('productos.store');
            Route::post('/productos/update/{id}', 'update')->middleware('permission:productos.editar')->name('productos.update');
            Route::post('/productos/delete/{id}', 'destroy')->middleware('permission:productos.eliminar')->name('productos.delete');
        });
    });

    // Gestión de Compras
    Route::middleware(['permission:compras.listar'])->group(function () {
        Route::controller(CompraController::class)->group(function () {
            Route::get('/compras', 'index')->name('compras.index');
            Route::get('/compras/create', 'create')->middleware('permission:compras.crear')->name('compras.create');
            Route::get('/compras/edit/{id}', 'edit')->name('compras.edit');
            Route::get('/compras/show/{id}', 'show')->name('compras.show');
            Route::post('/compras', 'store')->middleware('permission:compras.crear')->name('compras.store');
            Route::put('/compras/update/{id}', 'update')->name('compras.update');
            Route::post('/compras/delete/{id}', 'destroy')->name('compras.delete');
            Route::get('/compras/obtenerProductosPorAlmacen/{almacen_id}', 'obtenerProductosPorAlmacen')->name('compras.obtenerProductosPorAlmacen');
            Route::post('/compras/confirmarCompra/{id}', 'confirmarCompra')->name('compras.confirmarCompra');
        });
    });

        Route::controller(PagoController::class)->group(function () {
            Route::get('/pagos', 'index')->name('pagos.index');
            Route::get('/pagos/create', 'create')->name('pagos.create');
            Route::get('/pagos/create/{id}', 'createPago')->name('pagos.createPago');
            Route::get('/pagos/createfactura/{id}', 'createFactura')->name('pagos.createFactura');
            Route::post('/pagos/store', 'store')->name('pagos.store');
            Route::post('/pagos/update/{id}', 'update')->name('pagos.update');
        });

    // Gestión de Ventas
    Route::middleware(['permission:ventas.listar'])->group(function () {
        Route::controller(VentaController::class)->group(function () {
            Route::get('/ventas', 'index')->name('ventas.index');
            Route::get('/ventas/create', 'create')->middleware('permission:ventas.crear')->name('ventas.create');
            Route::get('/ventas/edit/{id}', 'edit')->name('ventas.edit');
            Route::get('/ventas/show/{id}', 'show')->name('ventas.show');
            Route::post('/ventas', 'store')->middleware('permission:ventas.crear')->name('ventas.store');
            Route::put('/ventas/update/{id}', 'update')->name('ventas.update');
            Route::post('/ventas/delete/{id}', 'destroy')->name('ventas.delete');
        });
    });

        Route::controller(AjusteInventarioController::class)->group(function () {
            Route::get('/ajustes-inventario', 'index')->name('ajustes.index');
            Route::get('/ajustes-inventario/create', 'create')->name('ajustes.create');
            Route::get('/ajustes-inventario/edit/{id}', 'edit')->name('ajustes.edit');
            Route::get('/ajustes-inventario/show/{id}', 'show')->name('ajustes.show');
            Route::post('/ajustes-inventario', 'store')->name('ajustes.store');
            Route::put('/ajustes-inventario/update/{id}', 'update')->name('ajustes.update');
            Route::post('/ajustes-inventario/delete/{id}', 'destroy')->name('ajustes.delete');
        });

    // Gestión de Reportes
    Route::middleware(['permission:reportes.consultar'])->group(function () {
        Route::controller(ReporteController::class)->group(function () {
            Route::get('/reportes-compras', 'reporteCompras')->name('reportes.compras');
            Route::get('/reportes-ventas', 'reporteVentas')->name('reportes.ventas');
            Route::get('/reportes-pagos', 'reportePagos')->name('reportes.pagos');
            Route::post('/reportes-ventas-resultados', 'mostrarVentasResultados')->name('reportes.mostrarVentasResultados');
            Route::post('/reportes-compras-resultados', 'mostrarComprasResultados')->name('reportes.mostrarComprasResultados');
        });
    });
        // Route::get('/send-email', [EmailController::class, 'showForm'])->name('show.email.form');
        // Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');
        Route::controller(EmailController::class)->group(function () {
            Route::post('/reporte/ventas', 'reporteVentas')->name('reportes.email.ventas');
            Route::post('/reporte/enviar-reporte-ventas', 'enviarReporteVentas')->name('reportes.enviar.ventas');
            Route::post('/reporte/compras', 'reporteCompras')->name('reportes.email.compras');
            Route::post('/reporte/enviar-reporte-compras', 'enviarReporteCompras')->name('reportes.enviar.compras');
        });
        Route::get('/search', [SearchController::class, 'search'])->name('search');

        Route::controller(PromocionController::class)->group(function () {
            Route::get('/promociones', 'index')->name('promociones.index');
            Route::get('/promociones/create', 'create')->name('promociones.create');
            Route::get('/promociones/edit/{promocion}', 'edit')->name('promociones.edit');
            Route::get('/promociones/show/{promocion}', 'show')->name('promociones.show');
            Route::post('/promociones', 'store')->name('promociones.store');
            Route::put('/promociones/update/{promocion}', 'update')->name('promociones.update');
            Route::post('/promociones/delete/{promocion}', 'destroy')->name('promociones.delete');
        });
});
