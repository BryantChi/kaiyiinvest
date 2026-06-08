<?php

/*
|--------------------------------------------------------------------------
| 前台可編輯內容區塊 manifest（彙整）
|--------------------------------------------------------------------------
|
| 實際定義放在 config/content/{page}.php，每檔回傳該頁的區塊定義陣列：
|   block key => ['type','label','group','default']
|     - type：text / textarea / html / image / url
|     - label：後台欄位名稱； group：後台分組標題
|     - default：預設值＝原靜態文案；DB 該語系無值時 fallback 至此
|
| 本檔將該目錄所有檔案以「檔名＝頁面 key」彙整成單一陣列，供 Content / cb() 使用。
| 'global' 為跨頁共用內容。只登記「原站實際可見」的內容（未顯示維持隱藏）。
|
| 注意：若執行過 config:cache，新增/修改 manifest 後需重新 php artisan config:cache。
|
*/

$pages = [];

foreach (glob(__DIR__ . '/content/*.php') as $file) {
    $pages[basename($file, '.php')] = require $file;
}

return $pages;
