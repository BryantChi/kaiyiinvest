<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\LocaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageSeoController extends Controller
{
    /**
     * 列出所有前台頁面，連到各頁各語系的 SEO 編輯。
     */
    public function index(): View
    {
        $pages = Page::ordered()->get();
        $locales = LocaleService::all();

        return view('admin.seo.pages.index', compact('pages', 'locales'));
    }

    /**
     * 編輯單一頁面某語系的 SEO。
     */
    public function edit(Request $request, string $pageKey): View
    {
        $page = Page::where('key', $pageKey)->firstOrFail();

        $locales = LocaleService::all();
        $locale = $request->get('locale', LocaleService::default());
        abort_unless(LocaleService::isSupported($locale), 404);

        $seo = $page->seoMeta()->where('locale', $locale)->first();

        return view('admin.seo.pages.edit', compact('page', 'seo', 'locales', 'locale'));
    }

    /**
     * 儲存單一頁面某語系的 SEO。
     */
    public function update(Request $request, string $pageKey): RedirectResponse
    {
        $page = Page::where('key', $pageKey)->firstOrFail();

        $locale = $request->get('locale', LocaleService::default());
        abort_unless(LocaleService::isSupported($locale), 404);

        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_robots' => 'nullable|string|max:100',
            'canonical_url' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:255',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|string|max:255',
            'twitter_card' => 'nullable|string|max:50',
            'schema_org' => ['nullable', 'string', function ($attr, $value, $fail) {
                if ($value !== null && trim($value) !== '') {
                    json_decode($value);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $fail('JSON-LD 格式錯誤：' . json_last_error_msg());
                    }
                }
            }],
        ]);

        // schema_org 由 JSON 字串轉陣列（model cast 為 array）
        $schemaText = $request->input('schema_org');
        $validated['schema_org'] = ($schemaText !== null && trim($schemaText) !== '')
            ? json_decode($schemaText, true)
            : null;

        $page->seoMeta()->updateOrCreate(
            ['locale' => $locale],
            $validated
        );

        flash_success('頁面 SEO 已更新（' . $locale . '）');

        return redirect()->route('admin.seo.pages.edit', ['pageKey' => $pageKey, 'locale' => $locale]);
    }
}
