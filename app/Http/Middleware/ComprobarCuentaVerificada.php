<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComprobarCuentaVerificada
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check() || auth()->user()->email_verified_at === null){
            return response()->json("Verify user account", 460);
        }

        return $next($request);
    }
}
