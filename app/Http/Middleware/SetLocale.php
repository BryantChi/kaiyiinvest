<?php

namespace App\Http\Middleware;

use App\Support\LocaleService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 設定 App locale。語系代碼由路由群組以中介層參數帶入（如 setlocale:en）；
 * 無參數時為預設語系。
 */
class SetLocale
{
    public function handle(Request $request, Closure $next, ?string $locale = null): Response
    {
        if ($locale === null || ! LocaleService::isSupported($locale)) {
            $locale = LocaleService::default();
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
