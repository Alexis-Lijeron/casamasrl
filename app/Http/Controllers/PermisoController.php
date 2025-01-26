<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Http\Requests\StorePermisoRequest;
use App\Http\Requests\UpdatePermisoRequest;
use App\Models\Rol;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permiso::all();
        return view('dashboard.permisos.index', compact('permisos'));
    }

    public function asignar()
    {
        $permisos = Permiso::all();
        $roles = Rol::all();

        return view('dashboard.permisos.asignar', compact('permisos', 'roles'));
    }

    public function obtenerPermisosRol($rol_id)
    {
        $rol = Rol::find($rol_id);

        if (!$rol) {
            return response()->json([
                'message' => 'Rol no encontrado'
            ], 404);
        }

        // Obtiene los permisos del rol
        $permisos = $rol->permisos;

        return response()->json($permisos, 200);
    }

    public function asignarPermiso(Request $request)
    {
        $rol = Rol::find($request->rol_id);
        $permiso = Permiso::find($request->permiso_id);

        if (!$rol || !$permiso) {
            return response()->json(['error' => 'Rol o permiso no encontrado'], 404);
        }

        // Asigna el permiso al rol
        $rol->permisos()->attach($permiso->id);
        return response()->json(['message' => 'Permiso asignado correctamente'], 200);
    }


    public function desasignarPermiso(Request $request)
    {
        $rol = Rol::find($request->rol_id);
        $permiso = Permiso::find($request->permiso_id);

        if (!$rol || !$permiso) {
            return response()->json(['error' => 'Rol o permiso no encontrado'], 404);
        }

        // Desasigna el permiso del rol utilizando detach en lugar de attach
        $rol->permisos()->detach($permiso->id);
        return response()->json(['message' => 'Permiso desasignado correctamente'], 200);
    }
    
    public function asignarTodosLosPermisos($rol_id)
    {
        $rol = Rol::find($rol_id);

        if (!$rol) {
            return response()->json([
                'message' => 'Rol no encontrado'
            ], 404);
        }

        // Obtiene todos los permisos
        $permisos = Permiso::all();

        // Asigna todos los permisos al rol
        $rol->permisos()->sync($permisos->pluck('id')->toArray());

        return response()->json([
            'message' => 'Permisos asignados con éxito'
        ], 200);
    }

    public function desasignarTodosLosPermisos($rol_id)
    {
        $rol = Rol::find($rol_id);

        if (!$rol) {
            return response()->json([
                'message' => 'Rol no encontrado'
            ], 404);
        }

        // Desasigna todos los permisos al rol
        $rol->permisos()->detach();

        return response()->json([
            'message' => 'Permisos desasignados con éxito'
        ], 200);
    }
}
