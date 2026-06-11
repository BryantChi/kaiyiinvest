<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\LocaleController;
use App\Http\Controllers\Admin\ImpersonationController;
use App\Http\Controllers\Admin\EngineerController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 後台管理系統路由
| 前綴: /admin
| 中介層: auth, verified (需要登入和驗證)
|
*/

Route::prefix(config('admin.prefix', 'admin'))
    ->name('admin.')
    ->middleware(['auth', 'verified', 'active'])
    ->group(function () {

        // 儀表板
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/system-info', [DashboardController::class, 'systemInfo'])->name('system-info');

        // 用戶管理
        Route::resource('users', UserController::class);

        // 啟用/停用帳號（由控制器把關：不可停用自己/工程師）
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

        // 模擬登入（限 super-admin，由控制器把關）
        Route::post('users/{user}/impersonate', [ImpersonationController::class, 'start'])->name('users.impersonate');

        // 文章管理
        Route::resource('articles', ArticleController::class);

        // 頁面內容（可編輯區塊，逐語系）
        Route::get('content', [PageContentController::class, 'index'])->name('content.index');
        Route::get('content/{pageKey}', [PageContentController::class, 'edit'])->name('content.edit');
        Route::put('content/{pageKey}', [PageContentController::class, 'update'])->name('content.update');

        // FAQ 管理（多語）
        Route::resource('faqs', FaqController::class)->except(['show']);

        // 聯絡訊息
        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::post('contacts/{contact}/mark-read', [ContactController::class, 'markRead'])->name('contacts.mark-read');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

        // 語系管理
        Route::resource('locales', LocaleController::class)->except(['show']);

        // 工程師工具（語系/Geo 開關 + 部署維運）— 僅工程師
        Route::middleware('engineer')->group(function () {
            Route::get('engineer', [EngineerController::class, 'index'])->name('engineer.index');
            Route::put('engineer/settings', [EngineerController::class, 'updateSettings'])->name('engineer.settings');
            Route::post('engineer/deploy/{action}', [EngineerController::class, 'deploy'])->name('engineer.deploy');
        });

        // 分類管理
        Route::resource('categories', CategoryController::class);

        // 標籤管理
        Route::resource('tags', TagController::class);
        Route::post('tags/{tag}/sync-count', [TagController::class, 'syncCount'])->name('tags.sync-count');
        Route::post('tags/sync-all-counts', [TagController::class, 'syncAllCounts'])->name('tags.sync-all-counts');

        // SEO 管理
        Route::prefix('seo')->name('seo.')->group(function () {
            Route::get('/', [SeoController::class, 'index'])->name('index');

            // 網站 SEO 設定（GA4 / GTM / 驗證碼 / 預設值）
            Route::get('/settings', [SeoController::class, 'settings'])->name('settings');
            Route::put('/settings', [SeoController::class, 'updateSettings'])->name('settings.update');

            // 頁面 SEO（每頁每語系 Meta / OG / Twitter / JSON-LD）
            Route::get('/pages', [PageSeoController::class, 'index'])->name('pages');
            Route::get('/pages/{pageKey}', [PageSeoController::class, 'edit'])->name('pages.edit');
            Route::put('/pages/{pageKey}', [PageSeoController::class, 'update'])->name('pages.update');

            // Sitemap（動態；提供資訊 + 通知搜尋引擎）
            Route::get('/sitemap', [SeoController::class, 'sitemap'])->name('sitemap');
            Route::post('/sitemap/ping', [SeoController::class, 'pingSitemap'])->name('sitemap.ping');

            // robots.txt / llms.txt（存 Setting，由前台動態路由輸出）
            Route::get('/robots-txt', [SeoController::class, 'robotsTxt'])->name('robots-txt');
            Route::put('/robots-txt', [SeoController::class, 'updateRobotsTxt'])->name('robots-txt.update');
            Route::get('/llms-txt', [SeoController::class, 'llmsTxt'])->name('llms-txt');
            Route::put('/llms-txt', [SeoController::class, 'updateLlmsTxt'])->name('llms-txt.update');

            // SEO 分析
            Route::get('/analyze', [SeoController::class, 'analyze'])->name('analyze');
            Route::post('/generate-missing', [SeoController::class, 'generateMissingSeoMeta'])->name('generate-missing');
        });

        // 系統設定
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');

            // 一般設定
            Route::get('/general', [SettingController::class, 'general'])->name('general');
            Route::put('/general', [SettingController::class, 'updateGeneral'])->name('general.update');

            // SEO 設定已整合至「SEO 管理 → 網站設定」；此處保留轉址避免舊連結失效
            Route::get('/seo', fn () => redirect()->route('admin.seo.settings'))->name('seo');

            // 分析（GA4/GTM）已整合至「SEO 管理 → 網站設定」；保留轉址避免舊連結失效
            Route::get('/analytics', fn () => redirect()->route('admin.seo.settings'))->name('analytics');

            // 郵件設定
            Route::get('/mail', [SettingController::class, 'mail'])->name('mail');
            Route::put('/mail', [SettingController::class, 'updateMail'])->name('mail.update');
            Route::post('/mail/test', [SettingController::class, 'sendTestMail'])->name('mail.test');

            // 快取管理
            Route::post('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');

            // 自訂設定
            Route::get('/create', [SettingController::class, 'create'])->name('create');
            Route::post('/', [SettingController::class, 'store'])->name('store');
            Route::get('/{setting}/edit', [SettingController::class, 'edit'])->name('edit');
            Route::put('/{setting}', [SettingController::class, 'update'])->name('update');
            Route::delete('/{setting}', [SettingController::class, 'destroy'])->name('destroy');
        });
    });
