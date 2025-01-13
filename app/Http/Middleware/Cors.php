<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            // Permite todos los orígenes
            ->header("Access-Control-Allow-Origin", "*")
            // Métodos que a los que se da acceso
            ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE")
            // Headers de la petición
            ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
    }
}
