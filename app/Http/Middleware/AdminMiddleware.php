<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;//use for authentication
use App\Models\User; //the model that represents the users table


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->role_id == User::ADMIN_ROLE_ID){
            return $next($request);
        }
        /***
         * Note: The Auth::check()--checks if the user is loggedin
         * the Auth::user()->role_id == User::ADMIN_ROLE_ID check if the role_id is equal to 1
         */
        return redirect()->route('index');
}
}