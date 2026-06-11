<?php

namespace App\Support;

/**
 * 站台級 SEO 設定存取層（單一來源）。
 * 讀取順序：Setting（後台可編輯，group 'seo'）→ config/seo.php / config 預設。
 * 社群 sameAs 與聯絡資訊重用前台可編輯內容區塊 cb('global', …)。
 */
class Seo
{
    /** 讀取一個 seo 設定（Setting key 形如 'seo.xxx'） */
    public static function get(string $key, $default = null)
    {
        return setting('seo.' . $key, $default);
    }

    public static function siteName(): string
    {
        return self::get('site_name') ?: (config('app.name') ?: '楷懿國際投資');
    }

    /** 標題後綴範本（如「 | 楷懿國際投資」）；可空 */
    public static function titleSuffix(): string
    {
        return (string) self::get('title_suffix', '');
    }

    public static function defaultDescription(): string
    {
        return self::get('default_description')
            ?: '楷懿國際投資專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。';
    }

    public static function defaultKeywords(): string
    {
        return self::get('default_keywords')
            ?: '楷懿國際投資,越南不動產,工業地產,工業區開發招商,包租代管,不動產代理,越南房地產投資,河內,海防';
    }

    /** 預設 OG 圖（相對路徑或網址）；fallback logo */
    public static function defaultOgImage(): string
    {
        $v = self::get('default_og_image');
        if ($v) {
            return \Illuminate\Support\Str::startsWith($v, ['http', '//']) ? $v : asset($v);
        }
        return asset('assets/img/logo/logo.png');
    }

    public static function ga4Id(): ?string
    {
        return self::get('ga4_id') ?: config('analytics.google.tracking_id') ?: null;
    }

    public static function gtmId(): ?string
    {
        return self::get('gtm_id') ?: null;
    }

    public static function googleVerification(): ?string
    {
        return self::get('google_verification') ?: null;
    }

    public static function bingVerification(): ?string
    {
        return self::get('bing_verification') ?: null;
    }

    public static function yandexVerification(): ?string
    {
        return self::get('yandex_verification') ?: null;
    }

    /** Twitter 帳號（@xxx），供 twitter:site / twitter:creator */
    public static function twitterSite(): ?string
    {
        $v = self::get('twitter_site');
        if (! $v) {
            return null;
        }
        return \Illuminate\Support\Str::startsWith($v, '@') ? $v : '@' . $v;
    }

    /** 全站 noindex 開關（上線前可整站不被索引） */
    public static function noindexSite(): bool
    {
        return (bool) self::get('noindex_site', false);
    }

    /** 正式網域（APP_URL；sitemap/robots/llms 對外網址一律用它） */
    public static function baseUrl(): string
    {
        return rtrim(config('app.url') ?: url('/'), '/');
    }

    /** robots.txt 內容（後台可覆寫；預設禁 /api + 指向 sitemap） */
    public static function robotsTxt(): string
    {
        $custom = self::get('robots_txt');
        return $custom ?: "User-agent: *\nDisallow: /api\n\nSitemap: " . self::baseUrl() . "/sitemap.xml\n";
    }

    /** llms.txt 內容（後台可覆寫；預設提供豐富的 AEO 摘要） */
    public static function llmsTxt(): string
    {
        $custom = self::get('llms_txt');
        if ($custom) {
            return $custom;
        }

        $home = self::baseUrl() . '/';
        return <<<TXT
# 楷懿國際投資 Kaiyi International Investment

> 專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。服務台灣與越南客戶。

## 關於
楷懿國際投資以「專業・責任・價值」為經營核心，整合集團資源，為客戶提供一站式跨國不動產投資服務。據點位於越南河內與海防。

## 服務項目
- 不動產代理：越南不動產買賣、租賃與投資仲介。
- 工業地產 / 工業區開發招商：協助政府與企業完成園區開發、廠房興建與招商媒合。
- 包租代管：物件出租、租金代收、租賃契約與日常維護全程代管。
- 專業諮詢：跨國不動產投資、市場分析與法規諮詢。

## 服務區域
越南（河內、海防）、台灣。

## 聯絡
- 台灣：+886 987-773-519
- 越南：+84 768-168-989
- Email：kaiyiinvest@gmail.com

## 網站
- 首頁：{$home}
- 語言版本：繁體中文（預設）、English（/en）、Tiếng Việt（/vi）
- 常見問題：{$home}faq
- 聯絡我們：{$home}contact
TXT;
    }

    /** 社群連結（非空），供 sameAs 與頁尾使用 */
    public static function sameAs(): array
    {
        $links = [];
        foreach (['facebook', 'instagram', 'linkedin', 'youtube'] as $k) {
            $url = cb('global', 'social.' . $k);
            if ($url) {
                $links[] = $url;
            }
        }
        return $links;
    }

    /** 組織結構化資料的基本資料（給 SchemaService 使用） */
    public static function organizationName(): string
    {
        return self::get('org_name') ?: (cb('global', 'company.name') ?: self::siteName());
    }

    public static function organizationEmail(): ?string
    {
        return cb('global', 'contact.email') ?: null;
    }

    /** 電話（去除非數字，保留 +） */
    public static function organizationPhones(): array
    {
        $phones = [];
        foreach (['contact.phone_tw', 'contact.phone_vn'] as $k) {
            $raw = cb('global', $k);
            if ($raw) {
                $phones[] = preg_replace('/[^0-9+]/', '', $raw);
            }
        }
        return array_values(array_filter($phones));
    }
}
