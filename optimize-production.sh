#!/usr/bin/env bash
#
# 正式環境優化腳本 — 在「部署到正式機」時執行，不要在開發機常駐執行
# （config/route 快取會凍結設定與路由；開發時請用 `php artisan optimize:clear`）。
#
# 用法：bash optimize-production.sh
#
set -e
cd "$(dirname "$0")"

echo "==> 1/5 安裝相依（正式、不含 dev、最佳化 autoloader）"
composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction

echo "==> 2/5 建構前端資產（壓縮）"
npm ci --omit=dev || npm install
npm run build

echo "==> 3/5 清除舊快取"
php artisan optimize:clear

echo "==> 4/5 建立快取（config / route / view / event）"
# 注意：多語前台路由在啟動時依資料庫的啟用語系註冊；
# 若日後於後台「語系管理」新增/停用語系，需重新執行本步驟（route:cache）。
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "==> 5/5 其他"
php artisan storage:link || true
# GeoIP 資料庫（若已設定 MAXMIND_LICENSE_KEY；低記憶體串流下載）
php artisan geoip:download || true

echo "✅ 正式環境優化完成"
