<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\DetectLocale;
use App\Support\LocaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class LocaleController extends Controller
{
    /**
     * 手動切換語言：設定偏好 cookie（覆寫自動偵測），導回同一頁的該語系版本。
     * 用路由名稱重建目標 URL，避免開放轉址風險。
     */
    public function switch(Request $request, string $code): RedirectResponse
    {
        $locale = LocaleService::isSupported($code) ? $code : LocaleService::default();

        Cookie::queue(DetectLocale::COOKIE, $locale, 60 * 24 * 365);

        $routeName = $request->query('route');
        if (is_string($routeName) && str_starts_with($routeName, 'frontend.') && Route::has($routeName)) {
            return redirect(localized_route($routeName, [], $locale));
        }

        return redirect(localized_route('frontend.home', [], $locale));
    }
}
