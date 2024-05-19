<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->url() === route('loginRoute') || $request->url() === route('signupRoute'))
            if(Auth::check()) {
                return Redirect(route('blogRoute'));
            }
        else
            if(!Auth::check()) {
                return Redirect(route('loginRoute'));
            }
        return $next($request);
    }
}
