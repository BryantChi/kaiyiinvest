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

    /**
     * 顯示 SEO 設定
     */
    public function seo(): View
    {
        $settings = Setting::getGroup('seo');

        return view('admin.settings.seo', compact('settings'));
    }

    /**
     * 更新 SEO 設定
     */
    public function updateSeo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'seo_default_title' => 'required|string|max:255',
            'seo_default_description' => 'required|string',
            'seo_default_keywords' => 'nullable|string',
            'seo_sitemap_enabled' => 'boolean',
            'seo_robots_enabled' => 'boolean',
        ]);

        Setting::setMany($validated, 'seo');

        flash_success('SEO 設定更新成功');

        return redirect()->back();
    }

    /**
     * 顯示分析設定
     */
    public function analytics(): View
    {
        $settings = Setting::getGroup('analytics');

        return view('admin.settings.analytics', compact('settings'));
    }

    /**
     * 更新分析設定
     */
    public function updateAnalytics(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'analytics_enabled' => 'boolean',
            'analytics_google_id' => 'nullable|string',
            'analytics_view_id' => 'nullable|string',
            'analytics_track_admin' => 'boolean',
        ]);

        Setting::setMany($validated, 'analytics');

        flash_success('分析設定更新成功');

        return redirect()->back();
    }

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
        \Illuminate\Support\Facades\Cache::flush();

        flash_success('快取已清除');

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
