<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin')) {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
