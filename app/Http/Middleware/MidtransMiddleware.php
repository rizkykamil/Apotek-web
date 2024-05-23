<?php

namespace App\Http\Middleware;

use Closure;
use Midtrans\Config;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MidtransMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$clientKey = config('midtrans.client_key');
        return $next($request);
    }
}
