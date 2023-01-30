<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$role)
    {
        if($request->user()->role !== $role){
            if($request->user()->role == 'vendor'){
                return redirect('admin/login');
            }
            if($request->user()->role == 'admin'){
                return redirect('vendor/login');
            }
            return redirect('/');
        }
        return $next($request);
    }
}
