<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * 工程師專用面板：語系/Geo 開關 + 部署工具。
 * 路由皆掛 'engineer' middleware，僅工程師可存取。
 */
class EngineerController extends Controller
{
    public function index(): View
    {
        $settings = [
            'locale_auto_detect' => (bool) setting('locale_auto_detect', true),
            'geoip_enabled' => (bool) setting('geoip_enabled', true),
        ];

        $dbPath = config('geoip.services.maxmind_database.database_path');

        $info = [
            'laravel' => app()->version(),
            'php' => PHP_VERSION,
            'env' => app()->environment(),
            'debug' => config('app.debug') ? '開啟' : '關閉',
            'maxmind_key' => filled(config('geoip.license_key')),
            'geoip_db' => $dbPath && file_exists($dbPath),
            'maintenance' => app()->isDownForMaintenance(),
        ];

        return view('admin.engineer.index', compact('settings', 'info'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        Setting::set('locale_auto_detect', $request->boolean('locale_auto_detect'), 'engineer');
        Setting::set('geoip_enabled', $request->boolean('geoip_enabled'), 'engineer');

        flash_success('設定已更新');

        return redirect()->route('admin.engineer.index');
    }

    /**
     * 執行白名單內的部署/維運指令。
     */
    public function deploy(Request $request, string $action): RedirectResponse
    {
        $output = '';

        try {
            switch ($action) {
                case 'clear-cache':
                    Artisan::call('optimize:clear');
                    $output = Artisan::output();
                    break;

                case 'build-cache':
                    Artisan::call('config:cache');
                    $output .= Artisan::output();
                    try {
                        Artisan::call('route:cache');
                        $output .= Artisan::output();
                    } catch (\Throwable $e) {
                        $output .= "route:cache 略過（{$e->getMessage()}）\n";
                    }
                    Artisan::call('view:cache');
                    $output .= Artisan::output();
                    break;

                case 'migrate':
                    Artisan::call('migrate', ['--force' => true]);
                    $output = Artisan::output();
                    break;

                case 'seed':
                    // 寫死只跑 db:seed --force：所有 seeder 皆 firstOrCreate，僅補建缺少資料、不覆寫既有內容。
                    // 刻意不支援 migrate:fresh / --seed，避免清庫風險。
                    Artisan::call('db:seed', ['--force' => true]);
                    $output = Artisan::output();
                    break;

                case 'geoip-update':
                    // 用自製串流指令：低記憶體、不需提高 memory_limit（適用受限正式環境）
                    Artisan::call('geoip:download');
                    $output = Artisan::output();
                    break;

                case 'storage-link':
                    Artisan::call('storage:link');
                    $output = Artisan::output();
                    break;

                case 'maintenance-on':
                    $secret = Str::random(24);
                    Artisan::call('down', ['--secret' => $secret]);
                    session()->flash('maintenance_secret', url($secret));
                    $output = "已進入維護模式。請用下方「繞過網址」存取網站；完成後記得關閉維護模式。\n";
                    break;

                case 'maintenance-off':
                    Artisan::call('up');
                    $output = Artisan::output();
                    break;

                default:
                    abort(404);
            }

            flash_success('指令完成：' . $action);
        } catch (\Throwable $e) {
            flash_error('執行失敗：' . $e->getMessage());
        }

        session()->flash('deploy_output', trim($output));

        return redirect()->route('admin.engineer.index');
    }
}
