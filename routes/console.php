<?php

use Illuminate\Support\Facades\Schedule;

// 每月更新 MaxMind GeoIP 資料庫（僅在已設定授權金鑰時執行）。
// 使用自製串流指令 geoip:download：低記憶體、不需提高 memory_limit，
// 適用記憶體受限且無法調整的正式環境。
Schedule::command('geoip:download')
    ->name('geoip-download')
    ->monthly()
    ->when(fn () => filled(env('MAXMIND_LICENSE_KEY')))
    ->onOneServer();
