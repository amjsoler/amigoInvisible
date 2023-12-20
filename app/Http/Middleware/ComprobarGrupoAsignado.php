<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComprobarGrupoAsignado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->grupo->integrantes_asignados){
            if($request->wantsJson()){
                return response()->json("El grupo ya ha celebrado las asignaciones", 461);
            }else{
                $nombregrupo = $request->grupo->nombre;
                return response()->view("pantallasDeError.461GrupoYaAsignado", compact("nombregrupo"));
            }
        }

        return $next($request);
    }
}
