<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * 顯示設定總覽
     */
    public function index(): View
    {
        $groups = Setting::select('group')
            ->distinct()
            ->pluck('group');

        $settings = Setting::orderBy('group')->orderBy('key')->get();

        return view('admin.settings.index', compact('groups', 'settings'));
    }

    /**
     * 顯示一般設定
     */
    public function general(): View
    {
        $settings = Setting::getGroup('general');

        return view('admin.settings.general', compact('settings'));
    }

    /**
     * 更新一般設定
     */
    public function updateGeneral(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_keywords' => 'nullable|string',
            'site_logo' => 'nullable|string',
            'site_favicon' => 'nullable|string',
            'admin_email' => 'required|email',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
        ]);

        Setting::setMany($validated, 'general');

        flash_success('一般設定更新成功');

        return redirect()->back();
    }

    // 註：SEO 與分析（GA4/GTM）設定已整合至「SEO 管理 → 網站設定」（admin.seo.settings）；
    //     原本的 seo()/updateSeo()/analytics()/updateAnalytics() 已移除，路由改為轉址。

    /**
     * 顯示郵件設定
     */
    public function mail(): View
    {
        $settings = Setting::getGroup('mail');

        return view('admin.settings.mail', compact('settings'));
    }

    /**
     * 更新郵件設定
     */
    public function updateMail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mail_driver' => 'required|string',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        Setting::setMany($validated, 'mail');

        flash_success('郵件設定更新成功');

        return redirect()->back();
    }

    /**
     * 清除快取
     */
    public function clearCache(): RedirectResponse
    {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');

        flash_success('快取已清除（config / route / view / cache）');

        return redirect()->back();
    }

    /**
     * 發送測試郵件（驗證 SMTP 設定）
     */
    public function sendTestMail(Request $request): RedirectResponse
    {
        $validated = $request->validate(['email' => 'required|email']);

        try {
            \Illuminate\Support\Facades\Mail::raw(
                "這是一封來自「" . config('app.name') . "」後台的測試郵件。\n寄送時間：" . now()->toDateTimeString(),
                function ($m) use ($validated) {
                    $m->to($validated['email'])->subject('【測試郵件】' . config('app.name'));
                }
            );
            flash_success('測試郵件已發送至 ' . $validated['email'] . '（請檢查收件匣 / 開發環境看 storage/logs）');
        } catch (\Throwable $e) {
            flash_error('測試郵件發送失敗：' . $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * 建立自訂設定
     */
    public function create(): View
    {
        return view('admin.settings.create');
    }

    /**
     * 儲存自訂設定
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'group' => 'required|string|max:50',
            'key' => 'required|string|max:100|unique:settings',
            'value' => 'required|string',
            'type' => 'required|in:string,integer,boolean,array,json',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
            'is_editable' => 'boolean',
        ]);

        Setting::create($validated);

        flash_success('設定建立成功');

        return redirect()->route('admin.settings.index');
    }

    /**
     * 編輯自訂設定
     */
    public function edit(Setting $setting): View
    {
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * 更新自訂設定
     */
    public function update(Request $request, Setting $setting): RedirectResponse
    {
        if (!$setting->is_editable) {
            flash_error('此設定不可編輯');
            return redirect()->back();
        }

        $validated = $request->validate([
            'value' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $setting->update($validated);

        flash_success('設定更新成功');

        return redirect()->route('admin.settings.index');
    }

    /**
     * 刪除自訂設定
     */
    public function destroy(Setting $setting): RedirectResponse
    {
        if (!$setting->is_editable) {
            flash_error('此設定不可刪除');
            return redirect()->back();
        }

        $setting->delete();

        flash_success('設定刪除成功');

        return redirect()->route('admin.settings.index');
    }
}
