@extends('layouts.admin')

@section('title', 'llms.txt（AEO）')

@php $breadcrumbs = [['title' => 'SEO 管理', 'url' => route('admin.seo.index')], ['title' => 'llms.txt', 'url' => '#']]; @endphp

@section('content')
<div class="row mb-4"><div class="col-12">
    <h2 class="mb-0">llms.txt（AEO）</h2>
    <p class="text-muted mb-0">提供 AI / 答案引擎理解網站的摘要。由 <a href="{{ url('/llms.txt') }}" target="_blank">/llms.txt</a> 動態輸出</p>
</div></div>

<div class="alert alert-info">
    llms.txt 是給生成式 AI（ChatGPT、Gemini 等）與答案引擎讀的「網站說明書」——清楚列出公司、服務、聯絡與重要連結，有助於被正確理解與引用（GEO/AEO）。
</div>

<form method="POST" action="{{ route('admin.seo.llms-txt.update') }}">
    @csrf @method('PUT')
    <div class="card mb-3">
        <div class="card-body">
            <textarea name="content" rows="20" class="form-control font-monospace">{{ old('content', $content) }}</textarea>
            <div class="form-text mt-2">建議用 Markdown；留空將回到系統預設摘要。</div>
        </div>
    </div>
    <div class="mb-4">
        <button class="btn btn-primary">儲存</button>
        <a href="{{ url('/llms.txt') }}" target="_blank" class="btn btn-light">預覽輸出</a>
        <a href="{{ route('admin.seo.index') }}" class="btn btn-light">返回</a>
    </div>
</form>
@endsection
