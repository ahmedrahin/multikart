<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Auth;

class isUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if( Auth::check() ){
        //     if( Auth::user()->status == 1 ){
        //         return $next($request);
        //     }else {
        //         session::flash('alert-type', 'error');
        //         session::flash('message', 'Your Account is Deactived');
        //         return redirect()->back();
        //     }
        // }
    }
}
