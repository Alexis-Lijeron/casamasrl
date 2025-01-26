<?php

use App\Models\Inventario;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

// function registrarBitacora($descripcion)
// {
//     $id_usuario = Session::get('usuario.id');
//     $ipUsuario = request()->ip();
//     $fecha = Carbon::now()->format('Y-m-d H:i:s');

//     $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
//     $response = Http::post($url . '/bitacoras', [
//         'fecha' => $fecha,
//         'ip_usuario' => $ipUsuario,
//         'descripcion' => $descripcion,
//         'id_usuario' => $id_usuario,
//     ]);
// }

if (!function_exists('getUsuario')) {
    function getUsuario()
    {
        // return Session::get('usuario');
        return Auth::user();
    }
}

// function verificarPermiso($permiso) {
//     $usuario = Session::get('usuario');

//     $rol = $usuario['rol']['nombre'];
//     $rol_id = $usuario['rol_id'];

//     if ($rol === "Administrador") {
//         return true;
//     }

//     $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
//     $response = Http::get($url . '/permisos-tienePermiso/'.$rol_id.'/'.$permiso);
//     $data = $response->json();
//     return $data['tienePermiso'];
// }

if (!function_exists('formatearFecha')) {
    function formatearFecha($fecha)
    {
        $carbonFecha = Carbon::parse($fecha);
        $fechaFormateada = $carbonFecha->format('d/m/Y - H:i:s A');
        return $fechaFormateada;
    }
}

if (!function_exists('formatoFecha')) {
    function formatoFecha($fecha)
    {
        $carbonFecha = Carbon::parse($fecha);
        $fechaFormateada = $carbonFecha->format('d/m/Y');
        return $fechaFormateada;
    }
}

if (!function_exists('formatoSinHora')) {
    function formatoSinHora($fecha)
    {
        // Convertir la fecha a un objeto DateTime
        $fechaObj = new DateTime($fecha);

        // Formatear la fecha a 'YYYY-MM-DD'
        $fechaFormateada = $fechaObj->format('Y-m-d');
        return $fechaFormateada;
    }
}

if (!function_exists('transformarFormatoFecha')) {
    function transformarFormatoFecha($fecha)
    {
        $fecha = DateTime::createFromFormat('d/m/Y', $fecha);
        return $fecha->format('Y-m-d');
    }
}

if (!function_exists('formatoFechaTexto')) {
    function formatoFechaTexto($fecha)
    {
        $fechaFormateada = Carbon::parse($fecha)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY');
        return $fechaFormateada;
    }
}

if (!function_exists('formatearNumero')) {
    function formatearNumero($numero)
    {
        return number_format($numero, 2, ',', '.');
    }
}

if (!function_exists('obtenerStockDisponible')) {
    function obtenerStockDisponible($productoId)
    {
        // Obtener el producto por ID
        $producto = Producto::find($productoId);

        // Si el producto no existe, devolver 0
        if (!$producto) {
            return 0;
        }

        // Calcular el stock total disponible sumando el stock de todos los almacenes
        $totalStock = $producto->almacenes->sum('pivot.stock');

        return $totalStock;
    }
}

if (!function_exists('obtenerStockDisponibleAlmacen')) {
    function obtenerStockDisponibleAlmacen($productoId, $almacenId)
    {
        // Obtener el producto por ID
        $producto = Producto::find($productoId);

        // Si el producto no existe, devolver 0
        if (!$producto) {
            return 0;
        }

        // Obtener el stock del producto en el almacén
        $stock = $producto->almacenes->find($almacenId)->pivot->stock;

        return $stock;
    }
}
