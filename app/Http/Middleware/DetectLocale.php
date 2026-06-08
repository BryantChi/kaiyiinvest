<?php

namespace App\Http\Middleware;

use App\Support\LocaleService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * 僅套用於「無前綴（預設語系）」前台路由：
 *  - 已有 preferred_locale cookie → 依其導向（記住的偏好）。
 *  - 首次造訪 → 偵測（瀏覽器語言 → IP 地區）後設 cookie 並導向。
 *  - 爬蟲、非 GET、AJAX 不導向（保留各語版可被收錄）。
 *  - 手動切換語言走 /lang/{code} 端點（會覆寫 cookie），不受此影響。
 */
class DetectLocale
{
    public const COOKIE = 'preferred_locale';

    public function handle(Request $request, Closure $next): Response
    {
        // 工程師可關閉整個語系自動偵測
        if (! setting('locale_auto_detect', true)) {
            return $next($request);
        }
        if (! $request->isMethod('get') || $request->ajax() || $request->wantsJson()) {
            return $next($request);
        }
        if ($this->isBot((string) $request->userAgent())) {
            return $next($request);
        }

        $default = LocaleService::default();
        $codes = LocaleService::codes();

        $cookie = $request->cookie(self::COOKIE);
        if ($cookie && in_array($cookie, $codes, true)) {
            $target = $cookie;
        } else {
            $target = $this->detect($request, $codes, $default);
            Cookie::queue(self::COOKIE, $target, 60 * 24 * 365);
        }

        if ($target !== $default) {
            $name = frontend_base_route_name(null);
            if ($name) {
                $params = $request->route()
                    ? collect($request->route()->parameters())->except('locale')->all()
                    : [];
                return redirect(localized_route($name, $params, $target));
            }
        }

        return $next($request);
    }

    /** 偵測順序：瀏覽器語言 → IP 地區（Cloudflare CF-IPCountry）→ 預設 */
    protected function detect(Request $request, array $codes, string $default): string
    {
        // 1) 瀏覽器語言（Accept-Language）
        foreach ($request->getLanguages() as $browser) {
            $browser = str_replace('_', '-', $browser);

            foreach ($codes as $c) {
                if (strcasecmp($c, $browser) === 0) {
                    return $c;
                }
            }
            $primary = strtolower(explode('-', $browser)[0]);
            foreach ($codes as $c) {
                if (strtolower(explode('-', $c)[0]) === $primary) {
                    return $c;
                }
            }
        }

        // 2) IP 地區
        $country = $this->detectCountry($request);
        if ($country) {
            $map = config('locales.country_map', []);
            if (isset($map[$country]) && in_array($map[$country], $codes, true)) {
                return $map[$country];
            }
        }

        return $default;
    }

    /**
     * 取得訪客國家代碼（ISO，大寫）：
     * 優先 Cloudflare CF-IPCountry 標頭；否則用 MaxMind GeoIP（torann/geoip）查 IP。
     * 私有/保留 IP、查無、套件未裝、資料庫缺失 → 回 null（安靜略過）。
     */
    protected function detectCountry(Request $request): ?string
    {
        // 工程師可關閉 IP 地區偵測（關閉後只用瀏覽器語言）
        if (! setting('geoip_enabled', true)) {
            return null;
        }

        $cf = strtoupper((string) $request->header('CF-IPCountry'));
        if ($cf && $cf !== 'XX' && strlen($cf) === 2) {
            return $cf;
        }

        if (! function_exists('geoip')) {
            return null;
        }

        $ip = $request->ip();
        // 排除私有/保留 IP（本機開發等）
        if (! $ip || ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return null;
        }

        try {
            $location = geoip()->getLocation($ip);
            if ($location && ! $location->default && $location->iso_code) {
                return strtoupper($location->iso_code);
            }
        } catch (\Throwable $e) {
            // 資料庫未安裝或查詢失敗 → 略過
        }

        return null;
    }

    protected function isBot(string $ua): bool
    {
        if ($ua === '') {
            return false;
        }
        return (bool) preg_match(
            '/bot|crawl|spider|slurp|googlebot|bingbot|baiduspider|yandex|duckduckbot|facebookexternalhit|embedly|quora|pinterest|whatsapp|telegrambot|applebot|semrush|ahrefs/i',
            $ua
        );
    }
}
