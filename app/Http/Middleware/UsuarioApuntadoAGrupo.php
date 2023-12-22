<?php

namespace App\Http\Middleware;

use App\Models\Integrante;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioApuntadoAGrupo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->grupo->integrantesDelGrupo()->where("usuario", auth()->user()->id)->count() != 1){
            return response()->json("No estás apuntado al grupo", 463);
        }

        return $next($request);
    }
}
