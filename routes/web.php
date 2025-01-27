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

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::controller(RolController::class)->group(function () {
    Route::get('/roles', 'index')->name('roles.index');
    Route::get('/roles/create', 'create')->name('roles.create');
    Route::get('/roles/show/{id}', 'show')->name('roles.show');
    Route::get('/roles/edit/{id}', 'edit')->name('roles.edit');
    Route::post('/roles', 'store')->name('roles.store');
    Route::post('/roles/update/{id}', 'update')->name('roles.update');
    Route::post('/roles/delete/{id}', 'destroy')->name('roles.delete');
});

Route::controller(PermisoController::class)->group(function () {
    Route::get('/permisos', 'index')->name('permisos.index');
    Route::get('/permisos/asignar', 'asignar')->name('permisos.asignar');
    Route::get('/permisos/obtenerPermisosRol/{rol_id}', 'obtenerPermisosRol')->name('permisos.obtenerPermisosRol');
    Route::post('/permisos/asignarPermiso', 'asignarPermiso')->name('permisos.asignarPermiso');
    Route::post('/permisos/desasignarPermiso', 'desasignarPermiso')->name('permisos.desasignarPermiso');
    Route::post('/permisos/asignarTodosLosPermisos/{rol_id}', 'asignarTodosLosPermisos')->name('permisos.asignarTodosLosPermisos');
    Route::post('/permisos/desasignarTodosLosPermisos/{rol_id}', 'desasignarTodosLosPermisos')->name('permisos.desasignarTodosLosPermisos');
});

Route::controller(UsuarioController::class)->group(function () {
    Route::get('/usuarios', 'index')->name('usuarios.index');
    Route::get('/usuarios/create', 'create')->name('usuarios.create');
    Route::get('/usuarios/show/{id}', 'show')->name('usuarios.show');
    Route::get('/usuarios/edit/{id}', 'edit')->name('usuarios.edit');
    Route::post('/usuarios', 'store')->name('usuarios.store');
    Route::post('/usuarios/update/{id}', 'update')->name('usuarios.update');
    Route::post('/usuarios/delete/{id}', 'destroy')->name('usuarios.delete');
});

Route::controller(ClienteController::class)->group(function () {
    Route::get('/clientes', 'index')->name('clientes.index');
    Route::get('/clientes/create', 'create')->name('clientes.create');
    Route::get('/clientes/edit/{id}', 'edit')->name('clientes.edit');
    Route::get('/clientes/show/{id}', 'show')->name('clientes.show');
    Route::post('/clientes', 'store')->name('clientes.store');
    Route::post('/clientes/update/{id}', 'update')->name('clientes.update');
    Route::post('/clientes/delete/{id}', 'destroy')->name('clientes.delete');
});

Route::controller(CategoriaController::class)->group(function () {
    Route::get('/categorias', 'index')->name('categorias.index');
    Route::get('/categorias/create', 'create')->name('categorias.create');
    Route::get('/categorias/edit/{id}', 'edit')->name('categorias.edit');
    Route::post('/categorias', 'store')->name('categorias.store');
    Route::post('/categorias/update/{id}', 'update')->name('categorias.update');
    Route::post('/categorias/delete/{id}', 'destroy')->name('categorias.delete');
});

Route::controller(MarcaController::class)->group(function () {
    Route::get('/marcas', 'index')->name('marcas.index');
    Route::get('/marcas/create', 'create')->name('marcas.create');
    Route::get('/marcas/show/{id}', 'show')->name('marcas.show');
    Route::get('/marcas/edit/{id}', 'edit')->name('marcas.edit');
    Route::post('/marcas', 'store')->name('marcas.store');
    Route::post('/marcas/update/{id}', 'update')->name('marcas.update');
    Route::post('/marcas/delete/{id}', 'destroy')->name('marcas.delete');
});

Route::controller(AlmacenController::class)->group(function () {
    Route::get('/almacenes', 'index')->name('almacenes.index');
    Route::get('/almacenes/create', 'create')->name('almacenes.create');
    Route::get('/almacenes/show/{id}', 'show')->name('almacenes.show');
    Route::get('/almacenes/edit/{id}', 'edit')->name('almacenes.edit');
    Route::post('/almacenes', 'store')->name('almacenes.store');
    Route::post('/almacenes/update/{id}', 'update')->name('almacenes.update');
    Route::post('/almacenes/delete/{id}', 'destroy')->name('almacenes.delete');
});

Route::controller(MetodoPagoController::class)->group(function () {
    Route::get('/metodos-pago', 'index')->name('metodos-pago.index');
    Route::get('/metodos-pago/create', 'create')->name('metodos-pago.create');
    Route::get('/metodos-pago/edit/{id}', 'edit')->name('metodos-pago.edit');
    Route::post('/metodos-pago', 'store')->name('metodos-pago.store');
    Route::post('/metodos-pago/update/{id}', 'update')->name('metodos-pago.update');
    Route::post('/metodos-pago/delete/{id}', 'destroy')->name('metodos-pago.delete');
});

Route::controller(ProveedorController::class)->group(function () {
    Route::get('/proveedor', 'index')->name('proveedor.index');
    Route::get('/proveedor/create', 'create')->name('proveedor.create');
    Route::get('/proveedor/edit/{id}', 'edit')->name('proveedor.edit');
    Route::post('/proveedor', 'store')->name('proveedor.store');
    Route::post('/proveedor/update/{id}', 'update')->name('proveedor.update');
    Route::post('/proveedor/delete/{id}', 'destroy')->name('proveedor.delete');
});

Route::controller(ProductoController::class)->group(function () {
    Route::get('/productos', 'index')->name('productos.index');
    Route::get('/productos/create', 'create')->name('productos.create');
    Route::get('/productos/edit/{id}', 'edit')->name('productos.edit');
    Route::get('/productos/show/{id}', 'show')->name('productos.show');
    Route::post('/productos', 'store')->name('productos.store');
    Route::post('/productos/update/{id}', 'update')->name('productos.update');
    Route::post('/productos/delete/{id}', 'destroy')->name('productos.delete');
});

Route::controller(CompraController::class)->group(function () {
    Route::get('/compras', 'index')->name('compras.index');
    Route::get('/compras/create', 'create')->name('compras.create');
    Route::get('/compras/edit/{id}', 'edit')->name('compras.edit');
    Route::get('/compras/show/{id}', 'show')->name('compras.show');
    Route::post('/compras', 'store')->name('compras.store');
    Route::put('/compras/update/{id}', 'update')->name('compras.update');
    Route::post('/compras/delete/{id}', 'destroy')->name('compras.delete');
    Route::get('/compras/obtenerProductosPorAlmacen/{almacen_id}', 'obtenerProductosPorAlmacen')->name('compras.obtenerProductosPorAlmacen');
    Route::post('/compras/confirmarCompra/{id}', 'confirmarCompra')->name('compras.confirmarCompra');
});

Route::controller(PagoController::class)->group(function () {
    Route::get('/pagos', 'index')->name('pagos.index');
    Route::get('/pagos/create', 'create')->name('pagos.create');
    Route::get('/pagos/create/{id}', 'createPago')->name('pagos.createPago');
    Route::get('/pagos/createfactura/{id}', 'createFactura')->name('pagos.createFactura');
    Route::post('/pagos/store', 'store')->name('pagos.store');
    Route::post('/pagos/update/{id}', 'update')->name('pagos.update');
});

Route::controller(VentaController::class)->group(function () {
    Route::get('/ventas', 'index')->name('ventas.index');
    Route::get('/ventas/create', 'create')->name('ventas.create');
    Route::get('/ventas/edit/{id}', 'edit')->name('ventas.edit');
    Route::get('/ventas/show/{id}', 'show')->name('ventas.show');
    Route::post('/ventas', 'store')->name('ventas.store');
    Route::put('/ventas/update/{id}', 'update')->name('ventas.update');
    Route::post('/ventas/delete/{id}', 'destroy')->name('ventas.delete');
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

Route::controller(ReporteController::class)->group(function () {
    Route::get('/reportes-compras', 'reporteCompras')->name('reportes.compras');
    Route::get('/reportes-ventas', 'reporteVentas')->name('reportes.ventas');
    Route::get('/reportes-pagos', 'reportePagos')->name('reportes.pagos');
    Route::post('/reportes-ventas-resultados', 'mostrarVentasResultados')->name('reportes.mostrarVentasResultados');
});
// Route::get('/send-email', [EmailController::class, 'showForm'])->name('show.email.form');
// Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');
Route::get('/report', [EmailController::class, 'report'])->name('report.index');
Route::post('/report/send_report', [EmailController::class, 'sendReport'])->name('report.sendReport');
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
