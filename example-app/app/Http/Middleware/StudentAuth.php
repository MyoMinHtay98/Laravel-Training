<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('STUDENT_ID')) {
            return $next($request);
        }
        abort(403, 'STUDENT LOGIN REQUIRED.');
    }
}
