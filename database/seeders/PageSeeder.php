<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['key' => 'home',                   'name' => '首頁',         'sort_order' => 1],
            ['key' => 'about',                  'name' => '關於我們',     'sort_order' => 2],
            ['key' => 'services',               'name' => '服務項目',     'sort_order' => 3],
            ['key' => 'industrial-development', 'name' => '工業區開發招商', 'sort_order' => 4],
            ['key' => 'rental-management',      'name' => '包租代管',     'sort_order' => 5],
            ['key' => 'partners',               'name' => '關係企業',     'sort_order' => 6],
            ['key' => 'faq',                    'name' => '常見問題',     'sort_order' => 7],
            ['key' => 'contact',                'name' => '聯絡我們',     'sort_order' => 8],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['key' => $page['key']], $page + ['is_active' => true]);
        }
    }
}
