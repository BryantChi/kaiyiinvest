<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\LocaleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 手動切換語言（設偏好 cookie 並導回該語系頁面）
Route::get('/lang/{code}', [LocaleController::class, 'switch'])->name('frontend.lang');

// 站台級 SEO 檔案（公開、動態產生）
Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap.xsl', [SitemapController::class, 'sitemapStyle'])->name('sitemap.xsl');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
Route::get('/llms.txt', [SitemapController::class, 'llms'])->name('llms');

// 前台官網路由（公開，不需登入）
// 多語：預設語系（zh-TW）無前綴；其餘語系以「字面前綴」各註冊一組（/en、/vi …）。
// 名稱：預設語系 frontend.about；語系版 frontend.en.about、frontend.vi.about。
// 用字面前綴而非可選 {locale?} 參數，可避免 Laravel 可選前綴的比對歧義。
$frontendRoutes = function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/services', [PageController::class, 'services'])->name('services');
    Route::get('/industrial-development', [PageController::class, 'industrialDevelopment'])->name('industrial-development');
    Route::get('/rental-management', [PageController::class, 'rentalManagement'])->name('rental-management');
    Route::get('/partners', [PageController::class, 'partners'])->name('partners');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    Route::get('/contact', [ContactController::class, 'show'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
};

// 預設語系（無前綴）：先偵測訪客語系（首次自動導向 + cookie 記住），再設 locale
Route::middleware(['detectlocale', 'setlocale'])->name('frontend.')->group($frontendRoutes);

// 各非預設語系（字面前綴），中介層帶入語系代碼
foreach (\App\Support\LocaleService::nonDefaultCodes() as $localeCode) {
    Route::prefix($localeCode)
        ->middleware('setlocale:' . $localeCode)
        ->name('frontend.' . $localeCode . '.')
        ->group($frontendRoutes);
}

// 認證路由（置於後台前綴下，不使用公開的 /login、/logout）
Route::prefix(config('admin.prefix', 'admin'))->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
    });

    Route::post('logout', [LoginController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});

// 結束模擬登入（只需 auth，不需 verified，確保被模擬者也能返回）
Route::post('impersonate/leave', [\App\Http\Controllers\Admin\ImpersonationController::class, 'leave'])
    ->middleware('auth')
    ->name('impersonate.leave');

// 載入後台路由
require __DIR__.'/admin.php';
