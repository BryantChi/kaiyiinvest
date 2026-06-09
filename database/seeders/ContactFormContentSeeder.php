<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Support\Content;
use Illuminate\Database\Seeder;

/**
 * 聯絡表單 / footer 電話國別標籤的 英文(en)＋越南文(vi) 翻譯種子。
 *
 * 繁中為 manifest(config/content/contact.php、global.php)的 default，不需入庫；
 * 此處僅補 en、vi。一律 firstOrCreate：已存在則保留後台編輯值，不覆寫；僅補建缺少者。
 *
 * 注意：執行此 seeder 會寫入 .env 指定的資料庫（目前為正式站）。
 * 執行：php artisan db:seed --class=Database\\Seeders\\ContactFormContentSeeder
 */
class ContactFormContentSeeder extends Seeder
{
    public function run(): void
    {
        // page => [key => [en, vi]]
        $data = [
            'contact' => [
                'form.name_label'          => ['Name', 'Họ và tên'],
                'form.email_label'         => ['Email', 'Email'],
                'form.phone_label'         => ['Phone', 'Số điện thoại'],
                'form.subject_label'       => ['Subject', 'Chủ đề'],
                'form.message_label'       => ['Message', 'Nội dung'],
                'form.subject_placeholder' => ['Please select a topic', 'Vui lòng chọn chủ đề'],
                'form.opt_real_estate'     => ['Real Estate Agency', 'Đại lý bất động sản'],
                'form.opt_industrial'      => ['Industrial Real Estate', 'Bất động sản công nghiệp'],
                'form.opt_consulting'      => ['Professional Consulting', 'Tư vấn chuyên nghiệp'],
                'form.opt_other'           => ['Other Services', 'Dịch vụ khác'],
                'form.opt_general'         => ['General Inquiry', 'Yêu cầu chung'],
                'form.submit'              => ['Send Message', 'Gửi tin nhắn'],
            ],
            'global' => [
                'contact.label_tw' => ['Taiwan', 'Đài Loan'],
                'contact.label_vn' => ['Vietnam', 'Việt Nam'],
            ],
        ];

        $locales = ['en' => 0, 'vi' => 1];

        foreach ($data as $page => $keys) {
            foreach ($keys as $key => $translations) {
                foreach ($locales as $locale => $idx) {
                    ContentBlock::firstOrCreate(
                        ['page' => $page, 'key' => $key, 'locale' => $locale],
                        ['type' => 'text', 'value' => $translations[$idx]]
                    );
                }
            }
        }

        Content::flush();

        $this->command->info('聯絡表單 / footer 國別標籤 en + vi 內容種子建立完成（contact, global）');
    }
}
