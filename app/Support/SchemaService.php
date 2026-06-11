<?php

namespace App\Support;

use App\Models\Faq;
use App\Models\Page;

/**
 * 集中產生 locale-aware 的 Schema.org 結構化資料（GEO/AEO）。
 * 取代各頁靜態 JSON-LD：Organization/RealEstateAgent、WebSite、每頁 BreadcrumbList、
 * FAQ 頁從 DB 動態產生 FAQPage、頁型（About/Contact/Service）。
 * 後台每頁每語系的 schema_org 仍可作為「額外補充」並存輸出（見 layout）。
 */
class SchemaService
{
    /** 公司據點（結構化地址 + 地圖；屬公司事實，少變動） */
    protected const ADDRESSES = [
        [
            'streetAddress' => 'SB01-SP.02-18, Sao Bien Subdivision, Vinhomes Ocean Park Urban Area',
            'addressLocality' => 'Gia Lam, Hanoi',
            'addressCountry' => 'VN',
        ],
        [
            'streetAddress' => 'So 449, Vo Nguyen Giap, Phuong Kenh Duong, Quan Le Chan',
            'addressLocality' => 'Hai Phong',
            'addressCountry' => 'VN',
        ],
    ];
    protected const MAPS = [
        'https://maps.app.goo.gl/UH9iwxsFqonbLx2D8?g_st=il',
        'https://maps.app.goo.gl/1r2e87E8h971Kisu7?g_st=il',
    ];

    /**
     * 產生目前頁面應輸出的所有 schema 圖（陣列）。
     */
    public static function forPage(string $pageKey, ?string $locale = null): array
    {
        $locale = $locale ?: app()->getLocale();
        $graphs = [];

        $graphs[] = self::organization();
        $graphs[] = self::website($locale);

        $breadcrumb = self::breadcrumb($pageKey, $locale);
        if ($breadcrumb) {
            $graphs[] = $breadcrumb;
        }

        $pageType = self::pageType($pageKey, $locale);
        if ($pageType) {
            $graphs[] = $pageType;
        }

        if ($pageKey === 'faq') {
            $faq = self::faqPage($locale);
            if ($faq) {
                $graphs[] = $faq;
            }
        }

        return array_values(array_filter($graphs));
    }

    /** RealEstateAgent（組織），含 sameAs / 聯絡 / 據點 */
    public static function organization(): array
    {
        $base = rtrim(config('app.url') ?: url('/'), '/');

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateAgent',
            '@id' => $base . '/#organization',
            'name' => Seo::organizationName(),
            'alternateName' => 'Kaiyi International Investment',
            'url' => $base . '/',
            'logo' => Seo::defaultOgImage(),
            'image' => Seo::defaultOgImage(),
            'description' => Seo::defaultDescription(),
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'Vietnam'],
                ['@type' => 'Country', 'name' => 'Taiwan'],
            ],
            'address' => array_map(fn ($a) => ['@type' => 'PostalAddress'] + $a, self::ADDRESSES),
            'hasMap' => self::MAPS,
        ];

        if ($email = Seo::organizationEmail()) {
            $data['email'] = $email;
        }
        if ($phones = Seo::organizationPhones()) {
            $data['telephone'] = $phones;
        }
        $data['sameAs'] = Seo::sameAs();

        return $data;
    }

    public static function website(string $locale): array
    {
        $base = rtrim(config('app.url') ?: url('/'), '/');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $base . '/#website',
            'url' => $base . '/',
            'name' => Seo::siteName() . ' ' . 'Kaiyi International Investment',
            'inLanguage' => $locale,
            'publisher' => ['@id' => $base . '/#organization'],
        ];
    }

    /** 麵包屑：首頁 → 當前頁（locale-aware；重用 generate_breadcrumb_schema helper） */
    public static function breadcrumb(string $pageKey, string $locale): ?array
    {
        if ($pageKey === 'home') {
            return null;
        }

        $homeName = $locale === 'zh-TW' ? '首頁' : ($locale === 'vi' ? 'Trang chủ' : 'Home');
        $items = [
            ['name' => $homeName, 'url' => localized_route('frontend.home', [], $locale)],
        ];

        $routeName = 'frontend.' . $pageKey;
        if (\Illuminate\Support\Facades\Route::has($routeName)) {
            $items[] = [
                'name' => self::pageLabel($pageKey, $locale),
                'url' => localized_route($routeName, [], $locale),
            ];
        }

        return generate_breadcrumb_schema($items);
    }

    /** FAQPage：從 DB Faq + 當前語系翻譯動態產生 */
    public static function faqPage(string $locale): ?array
    {
        try {
            $faqs = Faq::active()->ordered()->with('translations')->get();
        } catch (\Throwable $e) {
            return null;
        }

        $entities = [];
        foreach ($faqs as $faq) {
            $t = $faq->translation($locale);
            if (! $t || ! $t->question) {
                continue;
            }
            $entities[] = [
                '@type' => 'Question',
                'name' => $t->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => trim(strip_tags($t->answer)),
                ],
            ];
        }

        if (empty($entities)) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    /** 頁型 schema（About/Contact/Service…） */
    protected static function pageType(string $pageKey, string $locale): ?array
    {
        $base = rtrim(config('app.url') ?: url('/'), '/');
        $org = ['@id' => $base . '/#organization'];

        return match ($pageKey) {
            'about' => [
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => self::pageLabel('about', $locale),
                'inLanguage' => $locale,
                'about' => $org,
            ],
            'contact' => [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => self::pageLabel('contact', $locale),
                'inLanguage' => $locale,
                'about' => $org,
            ],
            'services', 'industrial-development', 'rental-management' => [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => self::pageLabel($pageKey, $locale),
                'provider' => $org,
                'areaServed' => [
                    ['@type' => 'Country', 'name' => 'Vietnam'],
                    ['@type' => 'Country', 'name' => 'Taiwan'],
                ],
            ],
            default => null,
        };
    }

    /** 取頁面在某語系的標籤：該語系 SEO 標題 → 內容 header.title → Page 名稱 */
    protected static function pageLabel(string $pageKey, string $locale): string
    {
        try {
            $page = Page::where('key', $pageKey)->first();
            if ($page) {
                $seo = $page->seoMeta()->where('locale', $locale)->first();
                if ($seo && $seo->meta_title) {
                    return $seo->meta_title;
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        $header = cb($pageKey, 'header.title', $locale);
        if ($header) {
            return $header;
        }

        $name = Page::where('key', $pageKey)->value('name');
        return $name ?: $pageKey;
    }
}
