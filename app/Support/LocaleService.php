<?php

namespace App\Support;

use App\Models\Locale;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * 多語系核心服務：提供啟用語系清單、預設語系等。
 *
 * - 讀取資料表 `locales`，結果快取（forever，異動時由 Locale model 清除）。
 * - 資料表不存在 / DB 未就緒（如 migrate 期間）時 fallback 至 config('locales.fallback')，
 *   確保 routes/web.php 在註冊路由時呼叫不致拋錯。
 */
class LocaleService
{
    public const CACHE_KEY = 'app.locales.active';

    /**
     * 啟用語系集合（已排序），每筆為含 code/name/native_name/is_default 的物件。
     */
    public static function all(): Collection
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            try {
                $rows = Locale::query()->active()->ordered()->get(
                    ['code', 'name', 'native_name', 'is_default']
                );

                if ($rows->isNotEmpty()) {
                    return $rows->map(fn ($l) => (object) [
                        'code' => $l->code,
                        'name' => $l->name,
                        'native_name' => $l->native_name ?: $l->name,
                        'is_default' => (bool) $l->is_default,
                    ])->values();
                }
            } catch (\Throwable $e) {
                // DB 未就緒，落入 fallback
            }

            return self::fallback();
        });
    }

    protected static function fallback(): Collection
    {
        return collect(config('locales.fallback', []))
            ->filter(fn ($l) => $l['is_active'] ?? true)
            ->map(fn ($l) => (object) [
                'code' => $l['code'],
                'name' => $l['name'],
                'native_name' => $l['native_name'] ?? $l['name'],
                'is_default' => (bool) ($l['is_default'] ?? false),
            ])->values();
    }

    /** 所有啟用語系代碼，如 ['zh-TW','en','vi'] */
    public static function codes(): array
    {
        return self::all()->pluck('code')->all();
    }

    /** 預設語系代碼（網址無前綴）；找不到時取第一個 */
    public static function default(): string
    {
        $all = self::all();
        return ($all->firstWhere('is_default', true)->code ?? null)
            ?? ($all->first()->code ?? 'zh-TW');
    }

    /** 非預設語系代碼（用於網址前綴約束），如 ['en','vi'] */
    public static function nonDefaultCodes(): array
    {
        $default = self::default();
        $codes = array_values(array_filter(self::codes(), fn ($c) => $c !== $default));

        // 永不為空：避免路由 whereIn 空陣列造成的非預期行為
        return $codes ?: ['en'];
    }

    public static function isSupported(?string $code): bool
    {
        return $code !== null && in_array($code, self::codes(), true);
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
