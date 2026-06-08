<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * 低記憶體下載/更新 MaxMind GeoLite2-City 資料庫。
 *
 * 不用 PharData（會整檔載入記憶體）；改以串流 gunzip + 手動解析 tar，
 * 邊讀邊寫、固定 8KB 緩衝，全程僅佔數 MB，與資料庫大小無關。
 * 適用記憶體受限且無法調整（ini_set 被禁）的正式環境。
 */
class GeoipDownload extends Command
{
    protected $signature = 'geoip:download {--edition=GeoLite2-City : MaxMind edition id}';

    protected $description = '以低記憶體串流方式下載/更新 GeoIP 資料庫（不需提高 memory_limit）';

    public function handle(): int
    {
        $key = env('MAXMIND_LICENSE_KEY');
        if (blank($key)) {
            $this->error('未設定 MAXMIND_LICENSE_KEY，無法下載。');
            return self::FAILURE;
        }

        $edition = $this->option('edition');
        $dbPath = config('geoip.services.maxmind_database.database_path', storage_path('app/geoip.mmdb'));
        @mkdir(dirname($dbPath), 0775, true);

        $url = sprintf(
            'https://download.maxmind.com/app/geoip_download?edition_id=%s&license_key=%s&suffix=tar.gz',
            $edition,
            $key
        );

        $tmpGz = $dbPath . '.download.tar.gz';
        $tmpDb = $dbPath . '.new';

        $this->info('下載中（串流）...');
        try {
            $resp = Http::timeout(180)->sink($tmpGz)->get($url);
        } catch (\Throwable $e) {
            @unlink($tmpGz);
            $this->error('下載失敗：' . $e->getMessage());
            return self::FAILURE;
        }

        if (! $resp->successful()) {
            @unlink($tmpGz);
            $this->error('下載失敗，HTTP ' . $resp->status() . '（請確認授權金鑰是否正確）');
            return self::FAILURE;
        }

        $this->info('解壓中（串流，低記憶體）...');
        $extracted = $this->streamExtractMmdb($tmpGz, $tmpDb);
        @unlink($tmpGz);

        if (! $extracted || ! is_file($tmpDb) || filesize($tmpDb) < 1_000_000) {
            @unlink($tmpDb);
            $this->error('解壓失敗或檔案異常（找不到 .mmdb 或檔案過小）。');
            return self::FAILURE;
        }

        // 原子替換
        if (! @rename($tmpDb, $dbPath)) {
            @unlink($tmpDb);
            $this->error('無法寫入資料庫檔：' . $dbPath . '（請檢查目錄權限）');
            return self::FAILURE;
        }

        $this->info('完成：' . $dbPath . '（' . round(filesize($dbPath) / 1048576, 1) . ' MB）');
        return self::SUCCESS;
    }

    /**
     * 串流解壓 .tar.gz，找出第一個 *.mmdb 寫到 $outPath。記憶體用量恆定。
     */
    protected function streamExtractMmdb(string $gzPath, string $outPath): bool
    {
        $gz = @gzopen($gzPath, 'rb');
        if (! $gz) {
            return false;
        }

        $found = false;

        while (! gzeof($gz)) {
            $header = $this->gzReadExact($gz, 512);
            if ($header === '' || strlen($header) < 512) {
                break;
            }
            // 結尾為全 0 區塊
            if (trim($header) === '') {
                continue;
            }

            $name = trim(substr($header, 0, 100));
            $size = (int) octdec(trim(substr($header, 124, 12)));
            $padded = $size + ((512 - ($size % 512)) % 512);

            if (str_ends_with($name, '.mmdb')) {
                $out = @fopen($outPath, 'wb');
                if (! $out) {
                    gzclose($gz);
                    return false;
                }
                $remaining = $size;
                while ($remaining > 0) {
                    $chunk = gzread($gz, (int) min(8192, $remaining));
                    if ($chunk === '' || $chunk === false) {
                        break;
                    }
                    fwrite($out, $chunk);
                    $remaining -= strlen($chunk);
                }
                fclose($out);
                $found = true;
                break;
            }

            // 非目標檔：跳過資料區（含 padding）
            $skip = $padded;
            while ($skip > 0) {
                $chunk = gzread($gz, (int) min(8192, $skip));
                if ($chunk === '' || $chunk === false) {
                    break;
                }
                $skip -= strlen($chunk);
            }
        }

        gzclose($gz);
        return $found;
    }

    /** 確保讀滿 n bytes（gzread 可能分段回傳）。 */
    protected function gzReadExact($gz, int $n): string
    {
        $buf = '';
        while (strlen($buf) < $n && ! gzeof($gz)) {
            $chunk = gzread($gz, $n - strlen($buf));
            if ($chunk === '' || $chunk === false) {
                break;
            }
            $buf .= $chunk;
        }
        return $buf;
    }
}
