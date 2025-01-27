<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReporteVentaRequest;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\NotaCompra;
use App\Models\NotaVenta;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    function reporteVentas()
    {
        $usuarios = Usuario::all();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $categorias = Categoria::all();
        return view('dashboard.reportes.ventas', compact('usuarios', 'clientes', 'productos', 'categorias'));
    }

    function reporteCompras()
    {
        $usuarios = Usuario::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $categorias = Categoria::all();
        return view('dashboard.reportes.compras', compact('usuarios', 'proveedores', 'productos', 'categorias'));
    }

    function reportePagos()
    {
        $usuarios = Usuario::all();
        $clientes = Cliente::all();
        return view('dashboard.reportes.pagos', compact('usuarios', 'clientes'));
    }

    function mostrarVentasResultados(ReporteVentaRequest $request)
    {
        // Recibir los parámetros de filtrado
        $usuario_id = $request->input('usuario');
        $cliente_id = $request->input('cliente');
        $producto_id = $request->input('producto');
        $categoria_id = $request->input('categoria');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');

        // Consulta de ventas (nota_ventas) con los filtros aplicados
        $query = NotaVenta::query();

        if ($usuario_id && $usuario_id != 0) {
            $query->where('usuario_id', $usuario_id);
        }

        if ($cliente_id && $cliente_id != 0) {
            $query->where('cliente_id', $cliente_id);
        }

        if ($producto_id && $producto_id != 0) {
            $query->whereHas('productosAlmacen', function ($q) use ($producto_id) {
                $q->where('producto_almacen.producto_id', $producto_id);
            });
        }

        if ($categoria_id && $categoria_id != 0) {
            $query->whereHas('productosAlmacen.producto.categoria', function ($q) use ($categoria_id) {
                $q->where('categoria_id', $categoria_id);
            });
        }

        if ($fecha_desde && $fecha_hasta) {
            $query->whereBetween('fecha_venta', [$fecha_desde, $fecha_hasta]);
        }

        $ventas = $query->with('productosAlmacen.producto.categoria', 'cliente', 'usuario')->get();
        return response()->json($ventas);
    }



    function mostrarComprasResultados(ReporteVentaRequest $request)
    {
        // Recibir los parámetros de filtrado
        $usuario_id = $request->input('usuario');
        $proveedor_id = $request->input('proveedor');
        $producto_id = $request->input('producto');
        $categoria_id = $request->input('categoria');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');

        // Consulta de compras (nota_compras) con los filtros aplicados
        $query = NotaCompra::query();

        if ($usuario_id && $usuario_id != 0) {
            $query->where('usuario_id', $usuario_id);
        }

        if ($proveedor_id && $proveedor_id != 0) {
            $query->where('proveedor_id', $proveedor_id);
        }

        if ($producto_id && $producto_id != 0) {
            $query->whereHas('productosAlmacen', function ($q) use ($producto_id) {
                $q->where('producto_almacen.producto_id', $producto_id);
            });
        }

        if ($categoria_id && $categoria_id != 0) {
            $query->whereHas('productosAlmacen.producto.categoria', function ($q) use ($categoria_id) {
                $q->where('categoria_id', $categoria_id);
            });
        }

        if ($fecha_desde && $fecha_hasta) {
            $query->whereBetween('fecha_compra', [$fecha_desde, $fecha_hasta]);
        }

        $compras = $query->with('productosAlmacen.producto.categoria', 'proveedor', 'usuario')->get();
        return response()->json($compras);
    }
}
