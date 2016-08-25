<?php

namespace App\Http\Middleware;

use Closure;

class CheckForMaintenanceMode
{
   
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        global $app;
        //排除IP
        if ($app->isDownForMaintenance() && ! in_array($request->getClientIp(), [
            '171.217.169.70',
            '127.0.0.1'
        ])) {
           return response()->view("errors.maintain",[],503);
        }
        
        return $next($request);
    }
}
