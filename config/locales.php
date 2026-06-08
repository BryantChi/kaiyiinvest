<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fallback 語系清單
    |--------------------------------------------------------------------------
    |
    | 當 locales 資料表尚未建立或無法讀取（如 migrate 期間）時，LocaleService
    | 會改用此清單，確保路由註冊不致失敗。實際運作以資料表為準（可後台擴充）。
    | 第一個 is_default=true 者為預設語系（網址無前綴）。
    |
    */
    'fallback' => [
        ['code' => 'zh-TW', 'name' => '繁體中文', 'native_name' => '繁體中文', 'is_default' => true,  'is_active' => true, 'sort_order' => 1],
        ['code' => 'en',    'name' => 'English',  'native_name' => 'English',  'is_default' => false, 'is_active' => true, 'sort_order' => 2],
        ['code' => 'vi',    'name' => 'Tiếng Việt', 'native_name' => 'Tiếng Việt', 'is_default' => false, 'is_active' => true, 'sort_order' => 3],
    ],

    /*
    |--------------------------------------------------------------------------
    | IP 地區 → 語系 對照（DetectLocale 在瀏覽器語言無法判斷時使用）
    |--------------------------------------------------------------------------
    | 需網站部署於 Cloudflare 後方（讀 CF-IPCountry 標頭）才會生效；
    | 其他環境若要啟用真正 GeoIP，需另接 MaxMind/GeoIP2。
    */
    'country_map' => [
        'VN' => 'vi',
        'TW' => 'zh-TW',
        'CN' => 'zh-TW',
        'HK' => 'zh-TW',
        'MO' => 'zh-TW',
        'SG' => 'zh-TW',
    ],
];
