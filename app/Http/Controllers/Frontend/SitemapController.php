<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\SeoMeta;
use App\Support\LocaleService;
use App\Support\Seo;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * 多語 sitemap.xml：每個啟用頁面 × 每個啟用語系，並含 hreflang alternates。
     */
    public function sitemap(): Response
    {
        // sitemap 一律使用正式網域（APP_URL），不跟隨存取主機（127.0.0.1 / localhost 等）
        $base = rtrim(config('app.url'), '/');
        \Illuminate\Support\Facades\URL::forceRootUrl($base);
        if (\Illuminate\Support\Str::startsWith($base, 'https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // 首頁（根網址）補上結尾斜線，使其為完整 URL 並與 canonical 一致
        $norm = fn (string $u) => $u === $base ? $base . '/' : $u;

        $pages = Page::active()->ordered()->get();
        $locales = LocaleService::all();

        // 每頁 lastmod：取該頁內容區塊 / SEO Meta / 頁面本身更新時間的最大值
        $blockUpdated = ContentBlock::selectRaw('page, MAX(updated_at) as u')->groupBy('page')->pluck('u', 'page');
        $seoUpdated = SeoMeta::where('model_type', Page::class)
            ->selectRaw('model_id, MAX(updated_at) as u')->groupBy('model_id')->pluck('u', 'model_id');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($pages as $page) {
            $routeName = 'frontend.' . $page->key;
            if (! \Illuminate\Support\Facades\Route::has($routeName)) {
                continue;
            }

            // lastmod
            $times = array_filter([
                $page->updated_at,
                $blockUpdated[$page->key] ?? null,
                $seoUpdated[$page->id] ?? null,
            ]);
            $lastmod = $times ? \Illuminate\Support\Carbon::parse(max($times))->toAtomString() : null;

            foreach ($locales as $loc) {
                $url = $norm(localized_route($routeName, [], $loc->code));
                $xml .= "  <url>\n";
                $xml .= '    <loc>' . htmlspecialchars($url, ENT_XML1) . "</loc>\n";

                // hreflang alternates（緊接 loc，符合 Google 範例）
                foreach ($locales as $alt) {
                    $altUrl = $norm(localized_route($routeName, [], $alt->code));
                    $xml .= '    <xhtml:link rel="alternate" hreflang="' . $alt->code . '" href="' . htmlspecialchars($altUrl, ENT_XML1) . "\"/>\n";
                    if ($alt->is_default) {
                        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($altUrl, ENT_XML1) . "\"/>\n";
                    }
                }

                if ($lastmod) {
                    $xml .= '    <lastmod>' . $lastmod . "</lastmod>\n";
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
        // 由後台「網站 SEO 設定」覆寫；不在 robots 列出後台路徑（避免洩漏自訂後台網址）。
        return response(Seo::robotsTxt(), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    /**
     * llms.txt（AEO）：由後台覆寫，預設提供豐富的公司與服務摘要。
     */
    public function llms(): Response
    {
        return response(Seo::llmsTxt(), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
