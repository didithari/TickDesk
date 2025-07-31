<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        switch (Auth::user()->privLevel) {
            //case 'admin': //NOT FINISHED
            //    return redirect('/admin/dashboard');
            //case 'super admin': NOT FINISHED
            //    return redirect('/superadmin/panel');
            case 'spv':
                return redirect()->route('SPV.spv');
            case 'developer':
                return redirect()->route('Developer.developer');
            case 'support':
                return redirect()->route('Chatsup.chatsup');
            default:
                return redirect('/')->withErrors(['Unauthorized role']);
        }

        return $next($request);
    }
}
