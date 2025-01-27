<?php

namespace App\Http\Controllers;

use App\Models\AjusteInventario;

class AjusteInventarioController extends Controller
{

    public function index()
    {
        $ajustes = AjusteInventario::all();
        return view('dashboard.ajuste_inventarios.index', compact('ajustes'));
    }
}
