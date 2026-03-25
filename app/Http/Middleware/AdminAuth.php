<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar sesión activa
        if (!Session::get('admin_auth')) {
            return redirect()->route('admin.login');
        }

        // Verificar que no haya expirado (8 horas)
        $expiry = Session::get('admin_expiry');
        if ($expiry && now()->timestamp > $expiry) {
            Session::forget(['admin_auth', 'admin_expiry']);
            return redirect()->route('admin.login')
                ->withErrors(['sesion' => 'Tu sesión expiró. Inicia sesión nuevamente.']);
        }

        return $next($request);
    }
}
