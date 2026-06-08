<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 僅允許工程師（最高權限內部角色）存取。
 */
class EnsureEngineer
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user() && $request->user()->isEngineer(), 403, '僅工程師可存取');

        return $next($request);
    }
}
