<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    function reporteVentas() {
        $usuarios = Usuario::all();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $categorias = Categoria::all();
        return view('dashboard.reportes.ventas', compact('usuarios', 'clientes', 'productos', 'categorias'));
    }
    
    function reporteCompras() {
        $usuarios = Usuario::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $categorias = Categoria::all();
        return view('dashboard.reportes.compras', compact('usuarios', 'proveedores', 'productos', 'categorias'));
    }
    
    function reportePagos() {
        $usuarios = Usuario::all();
        $clientes = Cliente::all();
        return view('dashboard.reportes.pagos', compact('usuarios', 'clientes'));
    }
}
