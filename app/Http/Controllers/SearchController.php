<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Define las secciones disponibles para búsqueda
        $sections = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Usuarios', 'url' => route('usuarios.index')],
            ['title' => 'Clientes', 'url' => route('clientes.index')],
            ['title' => 'Productos', 'url' => route('productos.index')],
            ['title' => 'Ventas', 'url' => route('ventas.index')],
            ['title' => 'Compras', 'url' => route('compras.index')],
            ['title' => 'Categorías', 'url' => route('categorias.index')],
            ['title' => 'Marcas', 'url' => route('marcas.index')],
            ['title' => 'Almacenes', 'url' => route('almacenes.index')],
            ['title' => 'Proveedores', 'url' => route('proveedor.index')],
            ['title' => 'Métodos de Pago', 'url' => route('metodos-pago.index')],
            ['title' => 'Pagos', 'url' => route('pagos.index')],
            ['title' => 'Promociones', 'url' => route('promociones.index')],
            ['title' => 'Reportes Compras', 'url' => route('reportes.compras')],
            ['title' => 'Reportes Ventas', 'url' => route('reportes.ventas')],
            ['title' => 'Reportes Pagos', 'url' => route('reportes.pagos')],
        ];

        $results = collect($sections)->filter(function ($section) use ($query) {
            return str_contains(strtolower($section['title']), strtolower($query));
        })->values();

        return response()->json($results);
    }
}
