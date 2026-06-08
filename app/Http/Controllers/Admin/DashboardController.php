<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * 顯示儀表板
     */
    public function index(): View
    {
        // 統計數據
        $stats = [
            'total_users' => User::count(),
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'draft_articles' => Article::draft()->count(),
            'total_categories' => Category::count(),
            'today_views' => AnalyticsEvent::today()->where('event_name', 'page_view')->count(),
        ];

        // 最近文章
        $recentArticles = Article::with(['author', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        // 熱門文章
        $popularArticles = Article::published()
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        // 每日瀏覽量 (最近 7 天)
        $dailyViews = $this->getDailyViews(7);

        // 熱門頁面
        $topPages = AnalyticsEvent::getTopPages(5, now()->subDays(7), now());

        return view('admin.dashboard.index', compact(
            'stats',
            'recentArticles',
            'popularArticles',
            'dailyViews',
            'topPages'
        ));
    }

    /**
     * 獲取每日瀏覽量
     */
    protected function getDailyViews(int $days = 7): array
    {
        $data = [];
        $startDate = now()->subDays($days - 1)->startOfDay();

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $count = AnalyticsEvent::whereDate('event_time', $date)
                ->where('event_name', 'page_view')
                ->count();

            $data[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('m/d'),
                'count' => $count,
            ];
        }

        return $data;
    }

    /**
     * 獲取系統資訊
     */
    public function systemInfo(): View
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'queue_driver' => config('queue.default'),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
        ];

        // 讀取已安裝的套件
        $packages = $this->getInstalledPackages();

        return view('admin.dashboard.system-info', compact('info', 'packages'));
    }

    /**
     * 獲取已安裝的套件列表
     */
    protected function getInstalledPackages(): array
    {
        $composerLockPath = base_path('composer.lock');

        if (!file_exists($composerLockPath)) {
            return [];
        }

        $composerLock = json_decode(file_get_contents($composerLockPath), true);
        $packages = [];

        // 只列出 require 區段的主要套件
        if (isset($composerLock['packages'])) {
            foreach ($composerLock['packages'] as $package) {
                // 過濾掉 Laravel 核心和一些系統套件
                if ($this->shouldShowPackage($package['name'])) {
                    $packages[] = [
                        'name' => $package['name'],
                        'version' => $package['version'],
                        'description' => $package['description'] ?? '',
                    ];
                }
            }
        }

        // 按名稱排序
        usort($packages, fn($a, $b) => strcmp($a['name'], $b['name']));

        return $packages;
    }

    /**
     * 判斷是否應該顯示該套件
     */
    protected function shouldShowPackage(string $packageName): bool
    {
        // 只顯示特定前綴的套件
        $allowedPrefixes = [
            'spatie/',
            'laravel/sanctum',
            'laravel/tinker',
            'laravel/telescope',
        ];

        foreach ($allowedPrefixes as $prefix) {
            if (str_starts_with($packageName, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
