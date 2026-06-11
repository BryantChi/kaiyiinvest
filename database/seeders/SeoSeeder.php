<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\SeoMeta;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * 針對「楷懿國際投資」客製的 SEO / GEO / AEO 種子。
 *
 * 內容分兩層：
 *  1) 站台級 SEO 設定（Setting group 'seo'，key 形如 seo.xxx）——對齊 App\Support\Seo
 *     與後台「SEO 管理 → 網站設定」實際讀寫的 key（舊 SettingSeeder 用 seo_* 底線 key，
 *     程式讀不到，已於此份重出並修正）。
 *  2) 每頁 × 每語系的 SeoMeta（meta / keywords / robots）＋每頁 WebPage + speakable
 *     的 schema_org 補充（GEO/AEO）。GEO 主結構（RealEstateAgent / WebSite / BreadcrumbList /
 *     Service / FAQPage）由 App\Support\SchemaService 依頁面+語系「自動」產生；此處的
 *     schema_org 以 isPartOf #website、about #organization 與其串接，並補上 speakable（AEO）。
 *
 * og_* / twitter_* 刻意不重複填寫：layout 會自動以 meta_title / meta_description 回退，
 * 之後在後台改 meta 時 og/twitter 仍自動同步，避免雙軌。
 *
 * 一律 firstOrCreate：已存在則保留後台編輯值，不覆寫；僅補建缺少者。
 */
class SeoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSiteSettings();
        $this->seedPageSeo();

        $this->command->info('SEO 種子建立完成（站台設定 + 每頁每語系 SeoMeta）');
    }

    /**
     * 站台級 SEO 設定（group 'seo'）。
     */
    protected function seedSiteSettings(): void
    {
        // 清除舊版 SettingSeeder 留下、程式讀不到的作廢 SEO key（底線命名；
        // 後台 SEO 設定頁讀寫的是 seo.* 點命名，從不碰這些，刪除安全）。
        Setting::whereIn('key', [
            'seo_default_title',
            'seo_default_description',
            'seo_default_keywords',
            'seo_sitemap_enabled',
            'seo_robots_enabled',
        ])->delete();

        $settings = [
            ['key' => 'seo.site_name',           'value' => '楷懿國際投資', 'type' => 'string', 'desc' => '網站名稱（SEO）', 'public' => true],
            ['key' => 'seo.title_suffix',        'value' => '', 'type' => 'string', 'desc' => '標題後綴範本（留空表示各頁標題已含品牌）', 'public' => true],
            ['key' => 'seo.default_description',  'value' => '楷懿國際投資專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。', 'type' => 'string', 'desc' => 'SEO 預設描述', 'public' => true],
            ['key' => 'seo.default_keywords',    'value' => '楷懿國際投資,越南不動產,工業地產,工業區開發招商,包租代管,不動產代理,越南房地產投資,河內,海防', 'type' => 'string', 'desc' => 'SEO 預設關鍵字', 'public' => true],
            ['key' => 'seo.default_og_image',    'value' => 'assets/img/logo/logo.png', 'type' => 'string', 'desc' => '預設 OG 分享圖（相對路徑或網址）', 'public' => true],
            ['key' => 'seo.twitter_site',        'value' => '', 'type' => 'string', 'desc' => 'Twitter/X 帳號（@xxx），供 twitter:site/creator', 'public' => true],
            ['key' => 'seo.noindex_site',        'value' => '0', 'type' => 'boolean', 'desc' => '全站 noindex（上線前可整站不被索引）', 'public' => false],
        ];

        foreach ($settings as $s) {
            Setting::firstOrCreate(
                ['key' => $s['key']],
                [
                    'group' => 'seo',
                    'value' => $s['value'],
                    'type' => $s['type'],
                    'description' => $s['desc'],
                    'is_public' => $s['public'],
                    'is_editable' => true,
                ]
            );
        }

        // Setting::get 以 rememberForever('settings') 快取；直接刪/建未清快取，這裡清一次。
        \Illuminate\Support\Facades\Cache::forget('settings');
    }

    /**
     * 每頁 × 每語系的 SeoMeta。
     */
    protected function seedPageSeo(): void
    {
        $base = rtrim(config('app.url') ?: 'https://kaiyiinvest.com', '/');
        $data = $this->pageSeoData();

        foreach ($data as $pageKey => $byLocale) {
            $page = Page::where('key', $pageKey)->first();
            if (! $page) {
                continue;
            }

            foreach ($byLocale as $locale => $m) {
                SeoMeta::firstOrCreate(
                    [
                        'model_type' => Page::class,
                        'model_id' => $page->id,
                        'locale' => $locale,
                    ],
                    [
                        'meta_title' => $m['title'],
                        'meta_description' => $m['desc'],
                        'meta_keywords' => $m['keywords'],
                        'meta_robots' => 'index, follow, max-image-preview:large',
                        'og_type' => 'website',
                        'schema_org' => $this->webPageSchema($m, $locale, $base),
                    ]
                );
            }
        }
    }

    /**
     * 每頁 WebPage + speakable schema（GEO 串接 + AEO）。
     * 以 isPartOf 指向 SchemaService 產生的 #website，about 指向 #organization，
     * 兩者合併為同一知識圖，speakable 提示語音/AI 可朗讀區塊。
     */
    protected function webPageSchema(array $m, string $locale, string $base): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $m['title'],
            'description' => $m['desc'],
            'inLanguage' => $locale,
            'isPartOf' => ['@id' => $base . '/#website'],
            'about' => ['@id' => $base . '/#organization'],
            'speakable' => [
                '@type' => 'SpeakableSpecification',
                'cssSelector' => ['h1', '.hero-subtitle', '.page-header'],
            ],
        ];
    }

    /**
     * 各頁、各語系的 meta 內容（zh-TW / en / vi）。
     * 標題建議 30–55 字元、描述 70–155 字元（後台分析器以此為準）。
     */
    protected function pageSeoData(): array
    {
        return [
            'home' => [
                'zh-TW' => [
                    'title' => '楷懿國際投資｜越南工業地產・不動產投資專家',
                    'desc' => '楷懿國際投資深耕越南河內、海防，提供工業區開發招商、工業地產、不動產代理與包租代管等一站式跨國不動產投資服務。',
                    'keywords' => '楷懿國際投資,越南不動產,工業地產,工業區開發招商,包租代管,不動產代理,河內,海防,越南投資',
                ],
                'en' => [
                    'title' => 'Kaiyi International Investment｜Vietnam Industrial Real Estate',
                    'desc' => 'Kaiyi International Investment delivers industrial real estate, zone development, brokerage and rental management across Hanoi and Haiphong, Vietnam.',
                    'keywords' => 'Kaiyi International Investment, Vietnam real estate, industrial real estate, industrial zone development, rental management, Hanoi, Haiphong',
                ],
                'vi' => [
                    'title' => 'Kaiyi International Investment｜BĐS công nghiệp Việt Nam',
                    'desc' => 'Kaiyi cung cấp bất động sản công nghiệp, phát triển khu công nghiệp, môi giới và quản lý cho thuê tại Hà Nội và Hải Phòng, Việt Nam.',
                    'keywords' => 'Kaiyi International Investment, bất động sản Việt Nam, bất động sản công nghiệp, phát triển khu công nghiệp, quản lý cho thuê, Hà Nội, Hải Phòng',
                ],
            ],
            'about' => [
                'zh-TW' => [
                    'title' => '關於楷懿｜專業・責任・價值的跨國不動產團隊',
                    'desc' => '認識楷懿國際投資：以專業、責任、價值為核心，整合集團資源，為台灣與越南客戶提供一站式跨國不動產投資服務。',
                    'keywords' => '關於楷懿,楷懿國際投資,公司簡介,越南不動產團隊,跨國投資,企業核心價值',
                ],
                'en' => [
                    'title' => 'About Kaiyi｜Cross-border Real Estate Investment Team',
                    'desc' => 'Built on professionalism, responsibility and value, Kaiyi International Investment offers one-stop cross-border property investment for Taiwan and Vietnam.',
                    'keywords' => 'about Kaiyi, Kaiyi International Investment, company profile, Vietnam real estate team, cross-border investment',
                ],
                'vi' => [
                    'title' => 'Về Kaiyi｜Đội ngũ đầu tư bất động sản xuyên quốc gia',
                    'desc' => 'Với giá trị cốt lõi chuyên nghiệp, trách nhiệm và giá trị, Kaiyi mang đến dịch vụ đầu tư bất động sản xuyên quốc gia trọn gói cho Đài Loan và Việt Nam.',
                    'keywords' => 'về Kaiyi, Kaiyi International Investment, giới thiệu công ty, đội ngũ bất động sản Việt Nam, đầu tư xuyên quốc gia',
                ],
            ],
            'services' => [
                'zh-TW' => [
                    'title' => '服務項目｜工業地產・不動產代理・包租代管・諮詢',
                    'desc' => '楷懿國際投資提供工業地產、工業區開發招商、不動產代理、包租代管與專業投資諮詢，涵蓋越南河內、海防全方位服務。',
                    'keywords' => '服務項目,工業地產,不動產代理,包租代管,工業區開發招商,投資諮詢,越南不動產服務',
                ],
                'en' => [
                    'title' => 'Services｜Industrial Real Estate, Brokerage & Management',
                    'desc' => 'Industrial real estate, zone development and investment promotion, brokerage, rental management and advisory across Hanoi and Haiphong, Vietnam.',
                    'keywords' => 'services, industrial real estate, real estate brokerage, rental management, zone development, investment advisory, Vietnam',
                ],
                'vi' => [
                    'title' => 'Dịch vụ｜BĐS công nghiệp, môi giới & quản lý cho thuê',
                    'desc' => 'Bất động sản công nghiệp, phát triển khu công nghiệp, môi giới, quản lý cho thuê và tư vấn đầu tư tại Hà Nội và Hải Phòng, Việt Nam.',
                    'keywords' => 'dịch vụ, bất động sản công nghiệp, môi giới bất động sản, quản lý cho thuê, phát triển khu công nghiệp, tư vấn đầu tư',
                ],
            ],
            'industrial-development' => [
                'zh-TW' => [
                    'title' => '工業區開發招商｜越南廠房與園區投資媒合',
                    'desc' => '協助政府與企業完成越南工業區開發、廠房興建與招商媒合，提供選址評估、土地取得到落地營運的全程服務。',
                    'keywords' => '工業區開發,招商,越南工業區,廠房興建,園區投資,選址評估,落地營運',
                ],
                'en' => [
                    'title' => 'Industrial Zone Development｜Vietnam Factory Investment',
                    'desc' => 'We support governments and enterprises with Vietnam industrial zone development, factory construction and investment matchmaking, from siting to operations.',
                    'keywords' => 'industrial zone development, investment promotion, Vietnam industrial park, factory construction, site selection, operations',
                ],
                'vi' => [
                    'title' => 'Phát triển khu công nghiệp｜Đầu tư nhà xưởng Việt Nam',
                    'desc' => 'Hỗ trợ chính phủ và doanh nghiệp phát triển khu công nghiệp, xây dựng nhà xưởng và kết nối đầu tư tại Việt Nam, từ chọn địa điểm đến vận hành.',
                    'keywords' => 'phát triển khu công nghiệp, xúc tiến đầu tư, khu công nghiệp Việt Nam, xây dựng nhà xưởng, chọn địa điểm',
                ],
            ],
            'rental-management' => [
                'zh-TW' => [
                    'title' => '包租代管｜越南物件出租與租賃全程代管',
                    'desc' => '楷懿提供越南不動產包租代管：物件出租、租金代收、租賃契約與日常維護全程代管，讓跨國置產輕鬆收租。',
                    'keywords' => '包租代管,越南租賃,物件出租,租金代收,物業管理,跨國置產,租賃契約',
                ],
                'en' => [
                    'title' => 'Rental Management｜End-to-end Leasing in Vietnam',
                    'desc' => 'Kaiyi handles Vietnam property rental management end to end: leasing, rent collection, contracts and maintenance for hassle-free cross-border ownership.',
                    'keywords' => 'rental management, Vietnam leasing, property management, rent collection, cross-border property, lease contracts',
                ],
                'vi' => [
                    'title' => 'Quản lý cho thuê｜Cho thuê trọn gói tại Việt Nam',
                    'desc' => 'Kaiyi quản lý cho thuê bất động sản tại Việt Nam trọn gói: cho thuê, thu tiền thuê, hợp đồng và bảo trì, giúp sở hữu xuyên quốc gia dễ dàng.',
                    'keywords' => 'quản lý cho thuê, cho thuê Việt Nam, quản lý tài sản, thu tiền thuê, bất động sản xuyên quốc gia, hợp đồng thuê',
                ],
            ],
            'partners' => [
                'zh-TW' => [
                    'title' => '關係企業｜楷懿集團跨國資源整合',
                    'desc' => '楷懿國際投資整合集團關係企業資源，串聯不動產、工程與數位行銷，為客戶打造完整的跨國投資與營運生態。',
                    'keywords' => '關係企業,楷懿集團,資源整合,策略夥伴,跨國投資,數位行銷',
                ],
                'en' => [
                    'title' => 'Affiliates｜Kaiyi Group Cross-border Resources',
                    'desc' => 'Kaiyi integrates group affiliates across real estate, engineering and digital marketing to build a complete cross-border investment ecosystem.',
                    'keywords' => 'affiliates, Kaiyi Group, partners, resource integration, cross-border investment, digital marketing',
                ],
                'vi' => [
                    'title' => 'Doanh nghiệp liên kết｜Nguồn lực Tập đoàn Kaiyi',
                    'desc' => 'Kaiyi tích hợp các doanh nghiệp liên kết trong lĩnh vực bất động sản, kỹ thuật và tiếp thị số để xây dựng hệ sinh thái đầu tư xuyên quốc gia.',
                    'keywords' => 'doanh nghiệp liên kết, Tập đoàn Kaiyi, đối tác, tích hợp nguồn lực, đầu tư xuyên quốc gia',
                ],
            ],
            'faq' => [
                'zh-TW' => [
                    'title' => '常見問題｜越南不動產投資疑問解答',
                    'desc' => '整理越南不動產投資、工業地產、包租代管與跨國置產的常見問題與專業解答，協助您快速掌握投資要點。',
                    'keywords' => '常見問題,FAQ,越南不動產,投資問答,工業地產,包租代管,跨國置產',
                ],
                'en' => [
                    'title' => 'FAQ｜Vietnam Real Estate Investment Questions',
                    'desc' => 'Answers to common questions on Vietnam real estate investment, industrial property, rental management and cross-border ownership.',
                    'keywords' => 'FAQ, Vietnam real estate, investment questions, industrial real estate, rental management, cross-border ownership',
                ],
                'vi' => [
                    'title' => 'Câu hỏi thường gặp｜Đầu tư BĐS Việt Nam',
                    'desc' => 'Giải đáp các câu hỏi thường gặp về đầu tư bất động sản Việt Nam, bất động sản công nghiệp, quản lý cho thuê và sở hữu xuyên quốc gia.',
                    'keywords' => 'câu hỏi thường gặp, FAQ, bất động sản Việt Nam, đầu tư, bất động sản công nghiệp, quản lý cho thuê',
                ],
            ],
            'contact' => [
                'zh-TW' => [
                    'title' => '聯絡我們｜楷懿國際投資台灣・越南據點',
                    'desc' => '與楷懿國際投資聯繫：台灣與越南河內、海防據點，提供工業地產與跨國不動產投資諮詢，歡迎來電或線上洽詢。',
                    'keywords' => '聯絡楷懿,聯絡我們,越南不動產諮詢,河內,海防,台灣,投資洽詢',
                ],
                'en' => [
                    'title' => 'Contact Us｜Kaiyi Taiwan & Vietnam Offices',
                    'desc' => 'Contact Kaiyi International Investment in Taiwan and Hanoi/Haiphong, Vietnam for industrial real estate and cross-border property advisory.',
                    'keywords' => 'contact Kaiyi, contact us, Vietnam real estate advisory, Hanoi, Haiphong, Taiwan',
                ],
                'vi' => [
                    'title' => 'Liên hệ｜Văn phòng Kaiyi Đài Loan & Việt Nam',
                    'desc' => 'Liên hệ Kaiyi International Investment tại Đài Loan và Hà Nội/Hải Phòng, Việt Nam để được tư vấn bất động sản công nghiệp và đầu tư xuyên quốc gia.',
                    'keywords' => 'liên hệ Kaiyi, liên hệ, tư vấn bất động sản Việt Nam, Hà Nội, Hải Phòng, Đài Loan',
                ],
            ],
        ];
    }
}
