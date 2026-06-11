@extends('layouts.admin')

@section('title', 'SEO 分析')

@php $breadcrumbs = [['title' => 'SEO 管理', 'url' => route('admin.seo.index')], ['title' => 'SEO 分析', 'url' => '#']]; @endphp

@section('content')
<div class="row mb-4"><div class="col-12 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="mb-0">SEO 分析</h2>
        <p class="text-muted mb-0">自動檢查網站 SEO/GEO/AEO 狀況</p>
    </div>
    <a href="{{ route('admin.seo.analyze') }}" class="btn btn-light">重新分析</a>
</div></div>

@php $map = ['warning' => ['warning text-dark', '⚠️'], 'info' => ['info text-dark', 'ℹ️'], 'danger' => ['danger', '⛔']]; @endphp

@if(count($issues) === 0)
<div class="card"><div class="card-body text-center py-5">
    <div style="font-size:2.5rem;">✅</div>
    <h4 class="mt-2">未發現明顯問題</h4>
    <p class="text-muted">主要 SEO/GEO/AEO 項目皆已設定。</p>
</div></div>
@else
<div class="card">
    <div class="card-header"><strong>發現 {{ count($issues) }} 項可優化</strong></div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @foreach($issues as $issue)
            @php [$cls, $emoji] = $map[$issue['severity']] ?? ['secondary', '•']; @endphp
            <div class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <span class="badge bg-{{ $cls }} me-2">{{ $emoji }}</span>
                    <strong>{{ $issue['title'] }}</strong>
                    <div class="small text-muted mt-1">{{ $issue['description'] }}</div>
                </div>
                @if(!empty($issue['action']))
                    @if(!empty($issue['action_post']))
                    <form method="POST" action="{{ $issue['action'] }}">@csrf
                        <button class="btn btn-sm btn-outline-primary">{{ $issue['action_label'] ?? '處理' }}</button>
                    </form>
                    @else
                    <a href="{{ $issue['action'] }}" class="btn btn-sm btn-outline-primary">{{ $issue['action_label'] ?? '前往' }}</a>
                    @endif
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
