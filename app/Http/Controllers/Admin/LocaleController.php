<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocaleController extends Controller
{
    public function index(): View
    {
        $locales = Locale::ordered()->get();
        return view('admin.locales.index', compact('locales'));
    }

    public function create(): View
    {
        return view('admin.locales.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $this->applyDefault($data);

        Locale::create($data);

        flash_success('語系已新增（新增非預設語系後，前台對應前綴路由將自動生效）');
        return redirect()->route('admin.locales.index');
    }

    public function edit(Locale $locale): View
    {
        return view('admin.locales.edit', compact('locale'));
    }

    public function update(Request $request, Locale $locale): RedirectResponse
    {
        $data = $this->validateData($request, $locale->id);
        $this->applyDefault($data);

        $locale->update($data);

        flash_success('語系已更新');
        return redirect()->route('admin.locales.index');
    }

    public function destroy(Locale $locale): RedirectResponse
    {
        if ($locale->is_default) {
            flash_error('無法刪除預設語系，請先指定其他語系為預設');
            return redirect()->back();
        }

        $locale->delete();

        flash_success('語系已刪除');
        return redirect()->route('admin.locales.index');
    }

    protected function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:locales,code' . ($ignoreId ? ",{$ignoreId}" : ''),
            'name' => 'required|string|max:100',
            'native_name' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_default'] = $request->boolean('is_default');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }

    /**
     * 設為預設時，清除其他語系的預設旗標；預設語系強制啟用。
     */
    protected function applyDefault(array &$data): void
    {
        if (! empty($data['is_default'])) {
            Locale::where('is_default', true)->update(['is_default' => false]);
            $data['is_active'] = true;
        }
    }
}
