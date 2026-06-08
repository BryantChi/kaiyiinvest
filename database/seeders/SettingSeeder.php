<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // 一般設定
            [
                'group' => 'general',
                'key' => 'site_name',
                'value' => config('app.name'),
                'type' => 'string',
                'description' => '網站名稱',
                'is_public' => true,
                'is_editable' => true,
            ],
            [
                'group' => 'general',
                'key' => 'site_description',
                'value' => '一個通用的後台管理系統',
                'type' => 'string',
                'description' => '網站描述',
                'is_public' => true,
                'is_editable' => true,
            ],
            [
                'group' => 'general',
                'key' => 'site_keywords',
                'value' => 'laravel, admin, cms',
                'type' => 'string',
                'description' => '網站關鍵字',
                'is_public' => true,
                'is_editable' => true,
            ],
            [
                'group' => 'general',
                'key' => 'admin_email',
                'value' => 'admin@example.com',
                'type' => 'string',
                'description' => '管理員信箱',
                'is_public' => false,
                'is_editable' => true,
            ],
            [
                'group' => 'general',
                'key' => 'timezone',
                'value' => 'Asia/Taipei',
                'type' => 'string',
                'description' => '時區',
                'is_public' => true,
                'is_editable' => true,
            ],
            [
                'group' => 'general',
                'key' => 'date_format',
                'value' => 'Y-m-d',
                'type' => 'string',
                'description' => '日期格式',
                'is_public' => true,
                'is_editable' => true,
            ],
            [
                'group' => 'general',
                'key' => 'time_format',
                'value' => 'H:i:s',
                'type' => 'string',
                'description' => '時間格式',
                'is_public' => true,
                'is_editable' => true,
            ],

            // SEO 設定
            [
                'group' => 'seo',
                'key' => 'seo_default_title',
                'value' => config('app.name'),
                'type' => 'string',
                'description' => 'SEO 預設標題',
                'is_public' => true,
                'is_editable' => true,
            ],
            [
                'group' => 'seo',
                'key' => 'seo_default_description',
                'value' => '一個通用的後台管理系統',
                'type' => 'string',
                'description' => 'SEO 預設描述',
                'is_public' => true,
                'is_editable' => true,
            ],
            [
                'group' => 'seo',
                'key' => 'seo_default_keywords',
                'value' => 'laravel, admin, cms',
                'type' => 'string',
                'description' => 'SEO 預設關鍵字',
                'is_public' => true,
                'is_editable' => true,
            ],
            [
                'group' => 'seo',
                'key' => 'seo_sitemap_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => '啟用 Sitemap',
                'is_public' => false,
                'is_editable' => true,
            ],
            [
                'group' => 'seo',
                'key' => 'seo_robots_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => '啟用 Robots.txt',
                'is_public' => false,
                'is_editable' => true,
            ],

            // 分析設定
            [
                'group' => 'analytics',
                'key' => 'analytics_enabled',
                'value' => 'false',
                'type' => 'boolean',
                'description' => '啟用 Google Analytics',
                'is_public' => false,
                'is_editable' => true,
            ],
            [
                'group' => 'analytics',
                'key' => 'analytics_google_id',
                'value' => '',
                'type' => 'string',
                'description' => 'Google Analytics ID',
                'is_public' => false,
                'is_editable' => true,
            ],
            [
                'group' => 'analytics',
                'key' => 'analytics_track_admin',
                'value' => 'false',
                'type' => 'boolean',
                'description' => '追蹤管理員',
                'is_public' => false,
                'is_editable' => true,
            ],

            // 郵件設定
            [
                'group' => 'mail',
                'key' => 'mail_driver',
                'value' => 'smtp',
                'type' => 'string',
                'description' => '郵件驅動',
                'is_public' => false,
                'is_editable' => true,
            ],
            [
                'group' => 'mail',
                'key' => 'mail_from_address',
                'value' => 'noreply@example.com',
                'type' => 'string',
                'description' => '寄件者信箱',
                'is_public' => false,
                'is_editable' => true,
            ],
            [
                'group' => 'mail',
                'key' => 'mail_from_name',
                'value' => config('app.name'),
                'type' => 'string',
                'description' => '寄件者名稱',
                'is_public' => false,
                'is_editable' => true,
            ],

            // 上傳設定
            [
                'group' => 'upload',
                'key' => 'upload_max_size',
                'value' => '10240',
                'type' => 'integer',
                'description' => '最大上傳檔案大小 (KB)',
                'is_public' => false,
                'is_editable' => true,
            ],
            [
                'group' => 'upload',
                'key' => 'upload_allowed_types',
                'value' => 'jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx',
                'type' => 'string',
                'description' => '允許上傳的檔案類型',
                'is_public' => false,
                'is_editable' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('系統設定已建立完成');
        $this->command->info('設定數量: ' . count($settings));
    }
}
