<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if( Auth::check() ){
            if( Auth::user()->role == 1 || Auth::user()->role == 3 ){
                return $next($request);
            }else if( Auth::user()->role == 2 ){
                return redirect()->route('error404');
            }else {
                return redirect()->route('error404');
            }
        }else {
            return redirect()->route('error404');
        }
    }
}
