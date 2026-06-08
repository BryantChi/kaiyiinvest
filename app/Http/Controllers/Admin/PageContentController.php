<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\Page;
use App\Support\Content;
use App\Support\LocaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageContentController extends Controller
{
    /**
     * 列出所有可編輯內容的頁面（含 global 共用區）。
     */
    public function index(): View
    {
        $pageNames = Page::pluck('name', 'key');

        $pages = collect(Content::manifestPages())->map(function ($key) use ($pageNames) {
            return (object) [
                'key' => $key,
                'name' => $key === 'global' ? '全站共用內容' : ($pageNames[$key] ?? $key),
                'block_count' => count(Content::forPage($key)),
            ];
        });

        $locales = LocaleService::all();

        return view('admin.page-content.index', compact('pages', 'locales'));
    }

    /**
     * 編輯單一頁面某語系的內容區塊。
     */
    public function edit(Request $request, string $pageKey): View
    {
        $blocks = Content::forPage($pageKey);
        abort_if(empty($blocks), 404);

        $locales = LocaleService::all();
        $locale = $request->get('locale', LocaleService::default());
        abort_unless(LocaleService::isSupported($locale), 404);

        // 該語系已存於 DB 的值（用於 prefill，未填者留空以顯示 placeholder）
        $saved = Content::raw($pageKey, $locale);

        // 依 group 分組（preserveKeys=true 保留區塊 key，否則會被重編為 0,1,2…）
        $grouped = collect($blocks)->groupBy(fn ($def) => $def['group'] ?? '其他', true);

        $pageName = $pageKey === 'global'
            ? '全站共用內容'
            : (Page::where('key', $pageKey)->value('name') ?? $pageKey);

        $defaultLocale = LocaleService::default();
        $defaultLocaleName = $locales->firstWhere('code', $defaultLocale)->native_name ?? $defaultLocale;

        return view('admin.page-content.edit', compact(
            'pageKey', 'pageName', 'grouped', 'locales', 'locale', 'saved',
            'defaultLocale', 'defaultLocaleName'
        ));
    }

    /**
     * 儲存某頁某語系的內容區塊。
     */
    public function update(Request $request, string $pageKey): RedirectResponse
    {
        $blocks = Content::forPage($pageKey);
        abort_if(empty($blocks), 404);

        $locale = $request->get('locale', LocaleService::default());
        abort_unless(LocaleService::isSupported($locale), 404);

        $values = $request->input('blocks', []);

        foreach ($blocks as $key => $def) {
            // 表單欄位名以 dot→雙底線轉碼，這裡用原始 key 取回
            $value = $values[$key] ?? null;

            ContentBlock::updateOrCreate(
                ['page' => $pageKey, 'key' => $key, 'locale' => $locale],
                ['type' => $def['type'] ?? 'text', 'value' => $value]
            );
        }

        Content::flush();
        flash_success('內容已更新（' . $locale . '）');

        return redirect()->route('admin.content.edit', ['pageKey' => $pageKey, 'locale' => $locale]);
    }
}
