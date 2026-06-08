<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Faq;
use App\Models\Page;
use App\Models\SeoMeta;
use App\Support\LocaleService;
use App\Support\Seo;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class SeoController extends Controller
{
    /**
     * SEO 總覽（真實統計）。
     */
    public function index(): View
    {
        $pages = Page::active()->count();
        $locales = LocaleService::all();
        $localeCount = $locales->count();

        $pageSeoCount = SeoMeta::where('model_type', Page::class)->count();
        $pageSeoTarget = max($pages * $localeCount, 1);

        $stats = [
            'pages' => $pages,
            'locales' => $localeCount,
            'sitemap_urls' => $pages * $localeCount,
            'page_seo' => $pageSeoCount,
            'coverage' => (int) round($pageSeoCount / $pageSeoTarget * 100),
            'faqs' => Faq::active()->count(),
            'articles_without_seo' => Article::doesntHave('seoMeta')->count(),
        ];

        $status = [
            'ga4' => (bool) Seo::ga4Id(),
            'gtm' => (bool) Seo::gtmId(),
            'google_verify' => (bool) Seo::googleVerification(),
            'bing_verify' => (bool) Seo::bingVerification(),
            'sameas' => count(Seo::sameAs()),
        ];

        return view('admin.seo.index', compact('stats', 'status'));
    }

    /**
     * 網站 SEO 設定（GA4 / GTM / 驗證碼 / 預設 OG 等）。
     */
    public function settings(): View
    {
        $s = [
            'site_name' => Seo::get('site_name', config('app.name')),
            'title_suffix' => Seo::get('title_suffix', ''),
            'default_description' => Seo::get('default_description', ''),
            'default_keywords' => Seo::get('default_keywords', ''),
            'default_og_image' => Seo::get('default_og_image', ''),
            'ga4_id' => Seo::get('ga4_id', ''),
            'gtm_id' => Seo::get('gtm_id', ''),
            'google_verification' => Seo::get('google_verification', ''),
            'bing_verification' => Seo::get('bing_verification', ''),
            'yandex_verification' => Seo::get('yandex_verification', ''),
            'twitter_site' => Seo::get('twitter_site', ''),
            'noindex_site' => (bool) Seo::get('noindex_site', false),
        ];

        return view('admin.seo.settings', compact('s'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:120',
            'title_suffix' => 'nullable|string|max:120',
            'default_description' => 'nullable|string|max:500',
            'default_keywords' => 'nullable|string|max:255',
            'default_og_image' => 'nullable|string|max:255',
            'ga4_id' => 'nullable|string|max:50',
            'gtm_id' => 'nullable|string|max:50',
            'google_verification' => 'nullable|string|max:120',
            'bing_verification' => 'nullable|string|max:120',
            'yandex_verification' => 'nullable|string|max:120',
            'twitter_site' => 'nullable|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            \App\Models\Setting::set('seo.' . $key, $value ?? '', 'seo');
        }
        \App\Models\Setting::set('seo.noindex_site', $request->boolean('noindex_site'), 'seo');

        flash_success('網站 SEO 設定已更新');
        return redirect()->route('admin.seo.settings');
    }

    /**
     * Sitemap 資訊（動態產生，無需手動生成）+ ping 搜尋引擎。
     */
    public function sitemap(): View
    {
        $pages = Page::active()->count();
        $locales = LocaleService::all()->count();
        $info = [
            'url' => url('/sitemap.xml'),
            'count' => $pages * $locales,
            'pages' => $pages,
            'locales' => $locales,
        ];

        return view('admin.seo.sitemap', compact('info'));
    }

    public function pingSitemap(): RedirectResponse
    {
        $sitemap = urlencode(url('/sitemap.xml'));
        $endpoints = [
            'https://www.google.com/ping?sitemap=' . $sitemap,
            'https://www.bing.com/ping?sitemap=' . $sitemap,
        ];

        try {
            Http::pool(fn (Pool $pool) => array_map(fn ($u) => $pool->timeout(10)->get($u), $endpoints));
            flash_success('已通知 Google 與 Bing 更新 Sitemap');
        } catch (\Throwable $e) {
            flash_warning('Sitemap 已可被抓取；通知搜尋引擎時發生問題：' . $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * robots.txt 編輯（存 Setting，由前台 /robots.txt 動態輸出，不寫實體檔）。
     */
    public function robotsTxt(): View
    {
        $content = Seo::robotsTxt();
        return view('admin.seo.robots-txt', compact('content'));
    }

    public function updateRobotsTxt(Request $request): RedirectResponse
    {
        $validated = $request->validate(['content' => 'nullable|string|max:10000']);
        \App\Models\Setting::set('seo.robots_txt', $validated['content'] ?? '', 'seo');

        flash_success('robots.txt 已更新');
        return redirect()->route('admin.seo.robots-txt');
    }

    /**
     * llms.txt 編輯（AEO；存 Setting，由前台 /llms.txt 動態輸出）。
     */
    public function llmsTxt(): View
    {
        $content = Seo::llmsTxt();
        return view('admin.seo.llms-txt', compact('content'));
    }

    public function updateLlmsTxt(Request $request): RedirectResponse
    {
        $validated = $request->validate(['content' => 'nullable|string|max:20000']);
        \App\Models\Setting::set('seo.llms_txt', $validated['content'] ?? '', 'seo');

        flash_success('llms.txt 已更新');
        return redirect()->route('admin.seo.llms-txt');
    }

    /**
     * SEO 分析（真實檢查）。
     */
    public function analyze(): View
    {
        $issues = [];
        $default = LocaleService::default();

        // 1. 頁面（預設語系）是否都有 SEO Meta
        $pagesMissing = [];
        foreach (Page::active()->ordered()->get() as $page) {
            $has = $page->seoMeta()->where('locale', $default)->exists();
            if (! $has) {
                $pagesMissing[] = $page->name;
            }
        }
        if ($pagesMissing) {
            $issues[] = [
                'severity' => 'warning',
                'title' => '頁面缺少 SEO Meta（' . $default . '）',
                'description' => implode('、', $pagesMissing) . ' 尚未設定 SEO Meta',
                'action' => route('admin.seo.pages'),
                'action_label' => '前往設定',
            ];
        }

        // 2. Meta 標題/描述長度
        $titleIssues = 0;
        $descIssues = 0;
        foreach (SeoMeta::whereNotNull('meta_title')->get() as $m) {
            if ($m->meta_title && ! validate_meta_title($m->meta_title)['is_optimal']) {
                $titleIssues++;
            }
            if ($m->meta_description && ! validate_meta_description($m->meta_description)['is_optimal']) {
                $descIssues++;
            }
        }
        if ($titleIssues) {
            $issues[] = ['severity' => 'info', 'title' => 'Meta 標題長度', 'description' => "{$titleIssues} 個標題長度不理想（建議 30-55 字元）"];
        }
        if ($descIssues) {
            $issues[] = ['severity' => 'info', 'title' => 'Meta 描述長度', 'description' => "{$descIssues} 個描述長度不理想（建議 70-155 字元）"];
        }

        // 3. 站台設定檢查
        if (! Seo::ga4Id() && ! Seo::gtmId()) {
            $issues[] = ['severity' => 'warning', 'title' => '未接分析工具', 'description' => '尚未設定 GA4 或 GTM，無法追蹤流量', 'action' => route('admin.seo.settings'), 'action_label' => '前往設定'];
        }
        if (! Seo::googleVerification()) {
            $issues[] = ['severity' => 'info', 'title' => 'Search Console 未驗證', 'description' => '建議設定 Google 驗證碼以使用 Search Console', 'action' => route('admin.seo.settings'), 'action_label' => '前往設定'];
        }
        if (! count(Seo::sameAs())) {
            $issues[] = ['severity' => 'info', 'title' => '未設定社群連結（sameAs）', 'description' => '補上 FB/IG/LinkedIn 有助於 AI 與搜尋引擎建立品牌關聯', 'action' => route('admin.content.edit', ['pageKey' => 'global', 'locale' => $default]), 'action_label' => '前往設定'];
        }

        // 4. 文章缺 SEO
        $articlesWithoutSeo = Article::doesntHave('seoMeta')->count();
        if ($articlesWithoutSeo > 0) {
            $issues[] = ['severity' => 'warning', 'title' => '文章缺少 SEO Meta', 'description' => "{$articlesWithoutSeo} 篇文章缺少 SEO Meta", 'action' => route('admin.seo.generate-missing'), 'action_label' => '批次生成', 'action_post' => true];
        }

        return view('admin.seo.analyze', compact('issues'));
    }

    /**
     * 批次為缺 SEO 的文章生成 SEO Meta。
     */
    public function generateMissingSeoMeta(): RedirectResponse
    {
        $count = 0;
        foreach (Article::doesntHave('seoMeta')->get() as $article) {
            $article->generateSeoMeta();
            $count++;
        }

        flash_success("已為 {$count} 篇文章生成 SEO Meta");
        return redirect()->back();
    }
}
