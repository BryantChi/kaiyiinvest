@extends('layouts.admin')

@section('title', 'Sitemap')

@php $breadcrumbs = [['title' => 'SEO 管理', 'url' => route('admin.seo.index')], ['title' => 'Sitemap', 'url' => '#']]; @endphp

@section('content')
<div class="row mb-4"><div class="col-12">
    <h2 class="mb-0">Sitemap</h2>
    <p class="text-muted mb-0">多語 sitemap.xml 為動態產生，內容永遠最新，無需手動生成</p>
</div></div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><strong>Sitemap 資訊</strong></div>
            <div class="card-body">
                <table class="table mb-0">
                    <tr><th style="width:160px;">網址</th><td><a href="{{ $info['url'] }}" target="_blank">{{ $info['url'] }}</a></td></tr>
                    <tr><th>URL 總數</th><td>{{ $info['count'] }}（{{ $info['pages'] }} 頁 × {{ $info['locales'] }} 語系）</td></tr>
                    <tr><th>多語</th><td>含 hreflang alternates + x-default</td></tr>
                    <tr><th>lastmod</th><td>依內容/ SEO 更新時間自動產生</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><strong>通知搜尋引擎</strong></div>
            <div class="card-body">
                <p class="small text-muted">告訴 Google / Bing 重新抓取 Sitemap。</p>
                <form method="POST" action="{{ route('admin.seo.sitemap.ping') }}">
                    @csrf
                    <button class="btn btn-primary w-100">
                        <svg class="icon me-1"><use xlink:href="/assets/icons/free.svg#cil-paper-plane"></use></svg>
                        通知 Google / Bing
                    </button>
                </form>
                <a href="{{ $info['url'] }}" target="_blank" class="btn btn-light w-100 mt-2">開啟 sitemap.xml</a>
            </div>
        </div>
    </div>
</div>
@endsection
