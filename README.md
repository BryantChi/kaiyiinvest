# 楷懿國際投資 Kaiyi International Investment

多語系企業官網 + Laravel 後台 CMS。深耕越南河內、海防，提供工業地產、不動產代理與專業諮詢。

- 正式網域：[kaiyiinvest.com](https://kaiyiinvest.com)
- 語系：繁體中文（預設，無前綴）、English（`/en`）、Tiếng Việt（`/vi`）

## 技術棧

Laravel 11 / PHP 8.2、Blade、MySQL 8、Vite 5、spatie/laravel-permission。

## 快速開始

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate

# 編輯 .env 設定 DB、APP_URL、ADMIN_PREFIX

php artisan migrate
php artisan db:seed        # 種子採 firstOrCreate，不覆寫既有資料
npm run dev
php artisan serve
```

- 官網：`http://localhost:8000/`
- 後台：`http://localhost:8000/<ADMIN_PREFIX>`（本專案為 `kaiyiinvest-console`）
- 預設管理員：`admin@example.com` / `password`（正式環境請立即更改）

## 多語系內容

前台文案以 `cb($page, $key)` 取值，解析順序：**目前語系 DB → 預設語系 DB → manifest 預設**。

- 繁中預設放 `config/content/{page}.php`，不需入庫；`en`／`vi` 翻譯存 `content_blocks`，可後台編輯或以 seeder 補。
- 每頁每語系 SEO（Meta／OG／hreflang／Sitemap／Schema.org）由 `page_seo()`、`SchemaService` 動態產生。

> 執行過 `config:cache` 後，改 manifest 需重新 `php artisan config:cache`。

## 文件

詳見 [`docs/`](docs/)（架構、SEO、路線圖等）。
