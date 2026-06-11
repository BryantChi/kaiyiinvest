<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Support\Content;
use Illuminate\Database\Seeder;

/**
 * 導覽列 / footer 選單的英文翻譯種子（content_blocks，locale=en）。
 *
 * 繁中為 manifest（config/content/global.php）的 default，不需入庫；
 * 此處僅補英文。越南文（vi）刻意留空，前台會自動 fallback 至繁中，待後台補。
 *
 * 一律 firstOrCreate：已存在則保留後台編輯值，不覆寫；僅補建缺少者。
 */
class NavContentSeeder extends Seeder
{
    public function run(): void
    {
        $en = [
            'nav.home'            => 'Home',
            'nav.about'           => 'About Us',
            'nav.services'        => 'Services',
            'nav.svc_real_estate' => 'Real Estate Agency',
            'nav.svc_industrial'  => 'Industrial Real Estate',
            'nav.svc_consulting'  => 'Professional Consulting',
            'nav.svc_other'       => 'Other Services',
            'nav.partners'        => 'Affiliates',
            'nav.contact'         => 'Contact Us',
            'footer.quick_links'  => 'Quick Links',
            'footer.contact_info' => 'Contact Info',
            // logo 副標 / footer 公司名共用此 key
            'company.name'        => 'Kaiyi International Investment',
        ];

        foreach ($en as $key => $value) {
            ContentBlock::firstOrCreate(
                ['page' => 'global', 'key' => $key, 'locale' => 'en'],
                ['type' => 'text', 'value' => $value]
            );
        }

        Content::flush();

        $this->command->info('導覽列 / footer 英文內容種子建立完成（global, en）');
    }
}
