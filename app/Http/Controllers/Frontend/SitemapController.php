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
        // XSL 樣式表：讓瀏覽器把 sitemap 顯示為美觀表格（搜尋引擎讀到的仍是同一份 XML）
        $xml .= '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>' . "\n";
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

    /**
     * sitemap.xsl：瀏覽器開啟 sitemap.xml 時套用的樣式表（顯示為美觀表格）。
     */
    public function sitemapStyle(): Response
    {
        $siteName = Seo::siteName();

        $xsl = <<<XSL
<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:s="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="http://www.w3.org/1999/xhtml">
<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
<xsl:template match="/">
<html lang="zh-TW">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>XML Sitemap — {$siteName}</title>
<style>
  :root{--gold:#c9a86a;--ink:#1a1a1c;--muted:#6b6b70;--line:#e7e7ea;--bg:#f6f6f4;}
  *{box-sizing:border-box;}
  body{margin:0;font-family:'Noto Sans TC',system-ui,-apple-system,sans-serif;background:var(--bg);color:var(--ink);}
  .wrap{max-width:1000px;margin:0 auto;padding:2.5rem 1.25rem;}
  header{border-bottom:2px solid var(--gold);padding-bottom:1rem;margin-bottom:1.25rem;}
  h1{margin:0;font-size:1.5rem;letter-spacing:.02em;}
  .sub{color:var(--muted);font-size:.9rem;margin-top:.4rem;line-height:1.6;}
  .count{display:inline-block;margin-top:.6rem;background:var(--ink);color:#fff;border-radius:999px;padding:.2rem .8rem;font-size:.8rem;}
  table{width:100%;border-collapse:collapse;background:#fff;border:1px solid var(--line);border-radius:10px;overflow:hidden;}
  th,td{text-align:left;padding:.7rem .9rem;font-size:.88rem;border-bottom:1px solid var(--line);vertical-align:top;}
  th{background:#fafafa;color:var(--muted);font-weight:600;letter-spacing:.04em;}
  tr:last-child td{border-bottom:none;}
  tr:hover td{background:#fcfbf8;}
  td a{color:#1257a8;text-decoration:none;word-break:break-all;}
  td a:hover{text-decoration:underline;}
  .lang{display:inline-block;background:#f0ece2;color:#8a6d29;border-radius:4px;padding:.05rem .4rem;font-size:.72rem;margin:0 .15rem .15rem 0;}
  .num{color:var(--muted);white-space:nowrap;}
  footer{color:var(--muted);font-size:.78rem;margin-top:1.25rem;text-align:center;}
</style>
</head>
<body>
<div class="wrap">
  <header>
    <h1>XML Sitemap</h1>
    <div class="sub">{$siteName} · 此頁為網站地圖，供搜尋引擎索引；瀏覽器以表格美化顯示，實際內容為標準 XML。</div>
    <span class="count"><xsl:value-of select="count(s:urlset/s:url)"/> 個網址</span>
  </header>
  <table>
    <thead>
      <tr><th>#</th><th>網址</th><th>語言版本</th><th>最後修改</th><th>頻率</th><th>優先度</th></tr>
    </thead>
    <tbody>
      <xsl:for-each select="s:urlset/s:url">
      <tr>
        <td class="num"><xsl:value-of select="position()"/></td>
        <td><a href="{s:loc}"><xsl:value-of select="s:loc"/></a></td>
        <td>
          <xsl:for-each select="xhtml:link[@rel='alternate'][@hreflang!='x-default']">
            <span class="lang"><xsl:value-of select="@hreflang"/></span>
          </xsl:for-each>
        </td>
        <td class="num"><xsl:value-of select="substring(s:lastmod,1,10)"/></td>
        <td class="num"><xsl:value-of select="s:changefreq"/></td>
        <td class="num"><xsl:value-of select="s:priority"/></td>
      </tr>
      </xsl:for-each>
    </tbody>
  </table>
  <footer>由 {$siteName} 自動產生</footer>
</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
XSL;

        return response($xsl, 200, ['Content-Type' => 'text/xsl; charset=UTF-8']);
    }
}
