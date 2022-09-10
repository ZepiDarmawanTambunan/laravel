<?php

namespace App\Http\Middleware;

use Closure;

class Pelanggan
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
        if (\Auth::user()->akses != 'pelanggan') {
            abort(401, 'Anda tidak dizinkan mengakses halaman ini');
        }
        return $next($request);
    }
}
