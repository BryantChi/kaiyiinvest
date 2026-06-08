@extends('layouts.admin')

@section('title', 'robots.txt')

@php $breadcrumbs = [['title' => 'SEO 管理', 'url' => route('admin.seo.index')], ['title' => 'robots.txt', 'url' => '#']]; @endphp

@section('content')
<div class="row mb-4"><div class="col-12">
    <h2 class="mb-0">robots.txt</h2>
    <p class="text-muted mb-0">爬蟲規則。內容存於資料庫，由 <a href="{{ url('/robots.txt') }}" target="_blank">/robots.txt</a> 動態輸出</p>
</div></div>

<form method="POST" action="{{ route('admin.seo.robots-txt.update') }}">
    @csrf @method('PUT')
    <div class="card mb-3">
        <div class="card-body">
            <textarea name="content" rows="14" class="form-control font-monospace">{{ old('content', $content) }}</textarea>
            <div class="form-text mt-2">
                提示：請保留 <code>Sitemap:</code> 指向 {{ url('/sitemap.xml') }}；勿在此公開後台路徑（避免洩漏）。留空將回到系統預設。
            </div>
        </div>
    </div>
    <div class="mb-4">
        <button class="btn btn-primary">儲存</button>
        <a href="{{ url('/robots.txt') }}" target="_blank" class="btn btn-light">預覽輸出</a>
        <a href="{{ route('admin.seo.index') }}" class="btn btn-light">返回</a>
    </div>
</form>
@endsection
