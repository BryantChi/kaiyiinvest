<?php

namespace App\Support;

use App\Models\ContentBlock;

/**
 * 可編輯內容區塊的解析與 manifest 存取。
 *
 * 解析順序：目前語系的 DB 值 → 預設語系的 DB 值 → manifest 預設值（原靜態文案）。
 * DB 值以「每頁一次查詢」載入請求內靜態快取；內容異動由 ContentBlock model 清除。
 */
class Content
{
    /** @var array<string, array<string, array<string, string|null>>> page => locale => key => value */
    protected static array $loaded = [];

    /** 取得整份 manifest（config/content.php） */
    public static function manifest(): array
    {
        return config('content', []);
    }

    /** 取得某頁的 manifest 區塊定義 */
    public static function forPage(string $page): array
    {
        return self::manifest()[$page] ?? [];
    }

    /** manifest 中所有有定義區塊的頁面 key */
    public static function manifestPages(): array
    {
        return array_keys(self::manifest());
    }

    protected static function ensureLoaded(string $page): void
    {
        if (isset(self::$loaded[$page])) {
            return;
        }

        self::$loaded[$page] = [];

        try {
            $rows = ContentBlock::where('page', $page)->get(['locale', 'key', 'value']);
            foreach ($rows as $row) {
                self::$loaded[$page][$row->locale][$row->key] = $row->value;
            }
        } catch (\Throwable $e) {
            // DB 未就緒：僅用 manifest 預設
        }
    }

    /**
     * 解析內容值。
     */
    public static function get(string $page, string $key, ?string $locale = null): ?string
    {
        self::ensureLoaded($page);

        $current = $locale ?: app()->getLocale();
        $default = LocaleService::default();

        $cur = self::$loaded[$page][$current][$key] ?? null;
        if ($cur !== null && $cur !== '') {
            return $cur;
        }

        if ($current !== $default) {
            $def = self::$loaded[$page][$default][$key] ?? null;
            if ($def !== null && $def !== '') {
                return $def;
            }
        }

        return self::forPage($page)[$key]['default'] ?? null;
    }

    /** 取得某頁某語系「已存於 DB」的原始值（後台編輯表單用，不做 fallback） */
    public static function raw(string $page, string $locale): array
    {
        self::ensureLoaded($page);
        return self::$loaded[$page][$locale] ?? [];
    }

    public static function flush(): void
    {
        self::$loaded = [];
    }
}
