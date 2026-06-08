<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Support\LocaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    /** 可選分類（key 對應前端 data-category） */
    public const CATEGORIES = [
        'contract' => '合約',
        'tax' => '稅務',
        'ownership' => '產權',
        'finance' => '金融',
    ];

    public function index(): View
    {
        $faqs = Faq::with('translations')->ordered()->paginate(30);
        $categories = self::CATEGORIES;
        return view('admin.faqs.index', compact('faqs', 'categories'));
    }

    public function create(): View
    {
        $locales = LocaleService::all();
        $categories = self::CATEGORIES;
        return view('admin.faqs.create', compact('locales', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        $faq = Faq::create([
            'category' => $this->normalizeCategory($request->input('category', [])),
            'order' => $request->input('order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->saveTranslations($faq, $data['translations']);

        flash_success('FAQ 建立成功');
        return redirect()->route('admin.faqs.index');
    }

    public function edit(Faq $faq): View
    {
        $faq->load('translations');
        $locales = LocaleService::all();
        $categories = self::CATEGORIES;
        return view('admin.faqs.edit', compact('faq', 'locales', 'categories'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $data = $this->validateData($request);

        $faq->update([
            'category' => $this->normalizeCategory($request->input('category', [])),
            'order' => $request->input('order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->saveTranslations($faq, $data['translations']);

        flash_success('FAQ 更新成功');
        return redirect()->route('admin.faqs.index');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete(); // translations 隨 cascade 刪除
        flash_success('FAQ 已刪除');
        return redirect()->route('admin.faqs.index');
    }

    protected function validateData(Request $request): array
    {
        $default = LocaleService::default();

        return $request->validate([
            'order' => 'nullable|integer',
            'category' => 'nullable|array',
            'translations' => 'required|array',
            // 預設語系的問題/答案必填，其餘語系可留空
            "translations.{$default}.question" => 'required|string|max:255',
            "translations.{$default}.answer" => 'required|string',
        ], [], [
            "translations.{$default}.question" => '預設語系問題',
            "translations.{$default}.answer" => '預設語系答案',
        ]);
    }

    protected function normalizeCategory(array $categories): ?string
    {
        $valid = array_intersect($categories, array_keys(self::CATEGORIES));
        return empty($valid) ? null : implode(' ', $valid);
    }

    protected function saveTranslations(Faq $faq, array $translations): void
    {
        foreach ($translations as $locale => $fields) {
            if (! LocaleService::isSupported($locale)) {
                continue;
            }

            $question = trim($fields['question'] ?? '');
            $answer = trim($fields['answer'] ?? '');

            // 該語系問與答皆空 → 刪除該翻譯（保持乾淨）
            if ($question === '' && $answer === '') {
                $faq->translations()->where('locale', $locale)->delete();
                continue;
            }

            $faq->translations()->updateOrCreate(
                ['locale' => $locale],
                ['question' => $question, 'answer' => $answer]
            );
        }
    }
}
