<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\LocaleService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * 多語 sitemap.xml：每個啟用頁面 × 每個啟用語系，並含 hreflang alternates。
     */
    public function sitemap(): Response
    {
        $pages = Page::active()->ordered()->get();
        $locales = LocaleService::all();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($pages as $page) {
            $routeName = 'frontend.' . $page->key;
            if (! \Illuminate\Support\Facades\Route::has($routeName)) {
                continue;
            }

            foreach ($locales as $loc) {
                $url = localized_route($routeName, [], $loc->code);
                $xml .= "  <url>\n";
                $xml .= '    <loc>' . htmlspecialchars($url, ENT_XML1) . "</loc>\n";

                // hreflang alternates
                foreach ($locales as $alt) {
                    $altUrl = localized_route($routeName, [], $alt->code);
                    $xml .= '    <xhtml:link rel="alternate" hreflang="' . $alt->code . '" href="' . htmlspecialchars($altUrl, ENT_XML1) . "\"/>\n";
                    if ($alt->is_default) {
                        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($altUrl, ENT_XML1) . "\"/>\n";
                    }
                }

                $xml .= "    <changefreq>weekly</changefreq>\n";
                $xml .= '    <priority>' . ($page->key === 'home' ? '1.0' : '0.8') . "</priority>\n";
                $xml .= "  </url>\n";
            }
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /**
     * robots.txt：可由設定覆寫，預設允許全部並指向 sitemap。
     */
    public function robots(): Response
    {
        $custom = setting('robots_txt');

        // 注意：不在 robots 列出後台路徑（避免洩漏自訂的後台網址）；後台本身已需登入。
        $content = $custom ?: "User-agent: *\nDisallow: /api\n\nSitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    /**
     * llms.txt（AEO）：可由設定覆寫，預設提供公司與服務摘要。
     */
    public function llms(): Response
    {
        $custom = setting('llms_txt');

        $default = <<<TXT
# 楷懿國際投資 Kaiyi International Investment

> 專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。

## 服務項目
- 不動產代理
- 工業地產 / 工業區開發招商
- 包租代管
- 專業諮詢

## 聯絡
- 台灣：+886 987-773-519
- 越南：+84 768-168-989
- Email：kaiyiinvest@gmail.com

## 網站
- 首頁：{$this->siteUrl()}
- 多語版本：zh-TW（預設）、en、vi
TXT;

        return response($custom ?: $default, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    protected function siteUrl(): string
    {
        return url('/');
    }
}
