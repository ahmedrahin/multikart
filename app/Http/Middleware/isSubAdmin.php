<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Auth;

class isSubAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( Auth::check() ){
            if( Auth::user()->role == 1 ){
                return $next($request);
            }else {
                // notification
                session::flash('alert-type', 'error');
                session::flash('message', 'Sorry!! You have no permission');
                return redirect()->back();
            }
        }
    }
}
