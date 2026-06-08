@extends('layouts.admin')

@section('title', '網站 SEO 設定')

@php $breadcrumbs = [['title' => 'SEO 管理', 'url' => route('admin.seo.index')], ['title' => '網站設定', 'url' => '#']]; @endphp

@section('content')
<div class="row mb-4"><div class="col-12">
    <h2 class="mb-0">網站 SEO 設定</h2>
    <p class="text-muted mb-0">全站預設值、分析工具與搜尋引擎驗證</p>
</div></div>

<form method="POST" action="{{ route('admin.seo.settings.update') }}">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="card-header"><strong>預設 Meta</strong></div>
                <div class="card-body">
                    @php
                        $fields = [
                            ['site_name', '網站名稱', 'text', ''],
                            ['title_suffix', '標題後綴（如「 | 楷懿國際投資」）', 'text', '留空則不加'],
                            ['default_description', '預設描述', 'textarea', '頁面未自訂時的描述'],
                            ['default_keywords', '預設關鍵字（逗號分隔）', 'text', ''],
                            ['default_og_image', '預設分享圖（路徑或網址）', 'text', '留空用 logo'],
                        ];
                    @endphp
                    @foreach($fields as [$name, $label, $type, $hint])
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>
                        @if($type === 'textarea')
                        <textarea name="{{ $name }}" rows="3" class="form-control">{{ old($name, $s[$name]) }}</textarea>
                        @else
                        <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name, $s[$name]) }}">
                        @endif
                        @if($hint)<div class="form-text">{{ $hint }}</div>@endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="card-header"><strong>分析與驗證</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Google Analytics 4 評估 ID</label>
                        <input type="text" name="ga4_id" class="form-control" value="{{ old('ga4_id', $s['ga4_id']) }}" placeholder="G-XXXXXXX">
                        <div class="form-text">設定後前台自動載入 gtag.js。</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Google Tag Manager ID</label>
                        <input type="text" name="gtm_id" class="form-control" value="{{ old('gtm_id', $s['gtm_id']) }}" placeholder="GTM-XXXXXX">
                        <div class="form-text">填了 GTM 則以 GTM 為主（GA4 改在 GTM 內設定）。</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Google Search Console 驗證碼</label>
                        <input type="text" name="google_verification" class="form-control" value="{{ old('google_verification', $s['google_verification']) }}">
                        <div class="form-text">輸出 &lt;meta name="google-site-verification"&gt;。</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bing 驗證碼</label>
                        <input type="text" name="bing_verification" class="form-control" value="{{ old('bing_verification', $s['bing_verification']) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yandex 驗證碼</label>
                        <input type="text" name="yandex_verification" class="form-control" value="{{ old('yandex_verification', $s['yandex_verification']) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Twitter / X 帳號</label>
                        <input type="text" name="twitter_site" class="form-control" value="{{ old('twitter_site', $s['twitter_site']) }}" placeholder="@kaiyiinvest">
                        <div class="form-text">用於 twitter:site / twitter:creator。</div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 border-warning">
                <div class="card-header bg-warning-subtle"><strong>整站索引控制</strong></div>
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input type="hidden" name="noindex_site" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="noindex_site" name="noindex_site" value="1" {{ old('noindex_site', $s['noindex_site']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="noindex_site">
                            <strong>整站 noindex（暫不被搜尋引擎收錄）</strong><br>
                            <small class="text-muted">上線前或維護期可開啟；正式上線請務必關閉，否則搜尋引擎不會收錄網站。</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4"><button class="btn btn-primary">儲存設定</button>
        <a href="{{ route('admin.seo.index') }}" class="btn btn-light">返回</a></div>
</form>
@endsection
