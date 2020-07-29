<?php

namespace App\Http\Middleware;

use Closure;
use App;

class Localization
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
        if (session()->has('user.locale')) {
            App::setLocale(session()->get('user.locale'));
            //echo (session()->get('user.locale'));
        }
        return $next($request);
    }
}
