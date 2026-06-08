<?php

namespace Database\Seeders;

use App\Models\Locale;
use App\Support\LocaleService;
use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    public function run(): void
    {
        $locales = [
            ['code' => 'zh-TW', 'name' => '繁體中文',   'native_name' => '繁體中文',   'is_default' => true,  'is_active' => true, 'sort_order' => 1],
            ['code' => 'en',    'name' => 'English',    'native_name' => 'English',    'is_default' => false, 'is_active' => true, 'sort_order' => 2],
            ['code' => 'vi',    'name' => 'Tiếng Việt', 'native_name' => 'Tiếng Việt', 'is_default' => false, 'is_active' => true, 'sort_order' => 3],
        ];

        foreach ($locales as $locale) {
            // firstOrCreate：語系已存在則保留後台設定（如啟用狀態），不覆寫
            Locale::firstOrCreate(['code' => $locale['code']], $locale);
        }

        LocaleService::clearCache();
    }
}
