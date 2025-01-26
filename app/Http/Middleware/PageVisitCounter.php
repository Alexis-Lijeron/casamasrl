<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageVisit;

class PageVisitCounter
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si la solicitud tiene una ruta válida
        $routeName = $request->route()?->getName();

        // Si no hay nombre de ruta, usa el path como identificador único
        $pageName = $routeName ?? $request->path();

        // Buscar o crear el registro para esta página
        $pageVisit = PageVisit::firstOrCreate(
            ['page_name' => $pageName],
            ['visit_count' => 0]
        );

        // Incrementar el contador
        $pageVisit->increment('visit_count');

        // Compartir el contador con las vistas
        view()->share('visitCount', $pageVisit->visit_count);

        return $next($request);
    }
}
