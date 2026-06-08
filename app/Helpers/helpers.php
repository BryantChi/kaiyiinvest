<?php

if (!function_exists('setting')) {
    /**
     * 獲取或設置系統配置
     */
    function setting(string $key, $default = null)
    {
        if (class_exists('\App\Models\Setting')) {
            return \App\Models\Setting::get($key, $default);
        }
        return $default;
    }
}

if (!function_exists('format_date')) {
    /**
     * 格式化日期
     */
    function format_date($date, string $format = 'Y-m-d H:i:s'): string
    {
        if (!$date) {
            return '';
        }

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->format($format);
    }
}

if (!function_exists('format_file_size')) {
    /**
     * 格式化文件大小
     */
    function format_file_size(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('active_route')) {
    /**
     * 檢查當前路由是否活動
     */
    function active_route(string|array $routes, string $activeClass = 'active'): string
    {
        $routes = is_array($routes) ? $routes : [$routes];

        foreach ($routes as $route) {
            if (request()->routeIs($route . '*')) {
                return $activeClass;
            }
        }

        return '';
    }
}

if (!function_exists('can_any')) {
    /**
     * 檢查用戶是否擁有任一權限
     */
    function can_any(array $permissions): bool
    {
        if (!auth()->check()) {
            return false;
        }

        foreach ($permissions as $permission) {
            if (auth()->user()->can($permission)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('admin_asset')) {
    /**
     * 獲取後台資源路徑
     */
    function admin_asset(string $path): string
    {
        return asset('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('truncate_html')) {
    /**
     * 截斷 HTML 內容
     */
    function truncate_html(string $html, int $length = 100, string $ending = '...'): string
    {
        $text = strip_tags($html);
        if (mb_strlen($text) > $length) {
            return mb_substr($text, 0, $length) . $ending;
        }
        return $text;
    }
}

if (!function_exists('generate_slug')) {
    /**
     * 生成 URL slug
     */
    function generate_slug(string $string): string
    {
        return \Illuminate\Support\Str::slug($string);
    }
}

if (!function_exists('flash_success')) {
    /**
     * 設置成功訊息
     */
    function flash_success(string $message): void
    {
        session()->flash('success', $message);
    }
}

if (!function_exists('flash_error')) {
    /**
     * 設置錯誤訊息
     */
    function flash_error(string $message): void
    {
        session()->flash('error', $message);
    }
}

if (!function_exists('flash_warning')) {
    /**
     * 設置警告訊息
     */
    function flash_warning(string $message): void
    {
        session()->flash('warning', $message);
    }
}

if (!function_exists('flash_info')) {
    /**
     * 設置資訊訊息
     */
    function flash_info(string $message): void
    {
        session()->flash('info', $message);
    }
}

if (!function_exists('localized_route')) {
    /**
     * 產生指定語系的前台具名路由 URL。
     * 接受「基底」路由名（如 frontend.about），預設語系直接用該名（無前綴），
     * 非預設語系改用語系版名稱（frontend.{locale}.about）。
     * 未指定 $locale 時用目前 App locale。
     */
    function localized_route(string $name, array $parameters = [], ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();

        if ($locale === \App\Support\LocaleService::default()) {
            return route($name, $parameters);
        }

        // frontend.about → frontend.en.about
        $parts = explode('.', $name, 2);
        $localizedName = count($parts) === 2
            ? $parts[0] . '.' . $locale . '.' . $parts[1]
            : $name;

        return \Illuminate\Support\Facades\Route::has($localizedName)
            ? route($localizedName, $parameters)
            : route($name, $parameters);
    }
}

if (!function_exists('is_impersonating')) {
    /**
     * 目前是否處於 super-admin 模擬登入狀態。
     */
    function is_impersonating(): bool
    {
        return session()->has('impersonate.by_id');
    }
}

if (!function_exists('impersonator_name')) {
    /**
     * 模擬登入時，原始操作者（super-admin）的名稱。
     */
    function impersonator_name(): ?string
    {
        return session('impersonate.by_name');
    }
}

if (!function_exists('current_page_key')) {
    /**
     * 由目前前台路由推得頁面 key（frontend.about → about；frontend.home → home）。
     */
    function current_page_key(): ?string
    {
        $base = frontend_base_route_name(null); // frontend.about
        if (! $base || ! str_starts_with($base, 'frontend.')) {
            return null;
        }
        return substr($base, strlen('frontend.'));
    }
}

if (!function_exists('page_seo')) {
    /**
     * 取得目前頁面當前語系的 SeoMeta（無則 fallback 預設語系；皆無回 null）。
     * 請求內快取。
     */
    function page_seo(): ?\App\Models\SeoMeta
    {
        static $cache = [];

        $key = current_page_key();
        if (! $key) {
            return null;
        }

        $locale = app()->getLocale();
        $cacheKey = $key . '|' . $locale;
        if (array_key_exists($cacheKey, $cache)) {
            return $cache[$cacheKey];
        }

        try {
            $page = \App\Models\Page::where('key', $key)->first();
            if (! $page) {
                return $cache[$cacheKey] = null;
            }

            $default = \App\Support\LocaleService::default();
            $seo = $page->seoMeta()->where('locale', $locale)->first();
            if (! $seo && $locale !== $default) {
                $seo = $page->seoMeta()->where('locale', $default)->first();
            }

            return $cache[$cacheKey] = $seo;
        } catch (\Throwable $e) {
            return $cache[$cacheKey] = null;
        }
    }
}

if (!function_exists('cb')) {
    /**
     * 取得可編輯內容區塊的值（content block）。
     * 解析：目前語系 DB → 預設語系 DB → manifest 預設值。
     * 文字型在 Blade 用 {{ cb(...) }}；html 型用 {!! cb(...) !!}。
     */
    function cb(string $page, string $key, ?string $locale = null): ?string
    {
        return \App\Support\Content::get($page, $key, $locale);
    }
}

if (!function_exists('cb_asset')) {
    /**
     * 取得圖片/資源型內容區塊的可用 URL。
     * 值為絕對網址則原樣回傳；否則視為 public 相對路徑套 asset()。
     */
    function cb_asset(string $page, string $key, ?string $locale = null): ?string
    {
        $value = \App\Support\Content::get($page, $key, $locale);
        if (! $value) {
            return null;
        }
        return \Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//'])
            ? $value
            : asset($value);
    }
}

if (!function_exists('frontend_base_route_name')) {
    /**
     * 取得目前前台路由的「基底名稱」（去掉語系段）。
     * frontend.en.about → frontend.about；frontend.about → frontend.about。
     */
    function frontend_base_route_name(?string $fallback = 'frontend.home'): string
    {
        $name = \Illuminate\Support\Facades\Route::currentRouteName();
        if (! $name) {
            return $fallback;
        }

        $parts = explode('.', $name);
        if (count($parts) >= 3
            && in_array($parts[1], \App\Support\LocaleService::nonDefaultCodes(), true)) {
            return $parts[0] . '.' . implode('.', array_slice($parts, 2));
        }

        return $name;
    }
}
