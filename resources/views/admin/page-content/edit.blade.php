@extends('layouts.admin')

@section('title', '編輯內容 - ' . $pageName)

@php
    $breadcrumbs = [
        ['title' => '頁面內容', 'url' => route('admin.content.index')],
        ['title' => $pageName, 'url' => '#'],
    ];
    // 前台預覽網址（global 對應首頁）
    $previewKey = $pageKey === 'global' ? 'home' : $pageKey;
    $previewUrl = \Illuminate\Support\Facades\Route::has('frontend.' . $previewKey)
        ? localized_route('frontend.' . $previewKey, [], $locale)
        : null;
    $isTranslating = $locale !== $defaultLocale;
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-0">{{ $pageName }}</h2>
            <p class="text-muted mb-0">編輯內容區塊</p>
        </div>
        @if($previewUrl)
        <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="btn btn-outline-secondary">
            <svg class="icon me-1"><use xlink:href="/assets/icons/free.svg#cil-external-link"></use></svg>
            前台預覽（{{ $locale }}）
        </a>
        @endif
    </div>
</div>

{{-- 語系切換 --}}
<ul class="nav nav-pills mb-3">
    @foreach($locales as $loc)
    <li class="nav-item">
        <a class="nav-link {{ $loc->code === $locale ? 'active' : '' }}"
           href="{{ route('admin.content.edit', ['pageKey' => $pageKey, 'locale' => $loc->code]) }}">
            {{ $loc->native_name }}
            @if($loc->is_default)<span class="badge bg-secondary ms-1">預設</span>@endif
        </a>
    </li>
    @endforeach
</ul>

<div class="alert {{ $isTranslating ? 'alert-warning' : 'alert-info' }}">
    @if($isTranslating)
        正在翻譯 <strong>{{ $locale }}</strong>。每個欄位下方顯示「{{ $defaultLocaleName }}原文」供對照；留空則前台自動 fallback 至{{ $defaultLocaleName }}。
    @else
        正在編輯預設語系 <strong>{{ $locale }}</strong>。留空的欄位前台會顯示系統原始文案。
    @endif
</div>

<form method="POST" action="{{ route('admin.content.update', ['pageKey' => $pageKey, 'locale' => $locale]) }}">
    @csrf
    @method('PUT')

    @foreach($grouped as $groupName => $items)
    @php $gid = 'grp' . $loop->index; @endphp
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center" role="button"
             style="cursor:pointer;" data-coreui-toggle="collapse" data-coreui-target="#{{ $gid }}">
            <strong>{{ $groupName }}</strong>
            <svg class="icon"><use xlink:href="/assets/icons/free.svg#cil-chevron-bottom"></use></svg>
        </div>
        <div class="collapse show" id="{{ $gid }}">
            <div class="card-body">
                @foreach($items as $key => $def)
                @php
                    $val = $saved[$key] ?? '';
                    $type = $def['type'] ?? 'text';
                    $source = $isTranslating ? cb($pageKey, $key, $defaultLocale) : null;
                @endphp
                <div class="mb-3">
                    <label class="form-label">
                        {{ $def['label'] ?? $key }}
                        <small class="text-muted">({{ $key }})</small>
                    </label>

                    @if($type === 'richtext' || $type === 'richtext-inline')
                        <textarea class="form-control {{ $type === 'richtext-inline' ? 'js-richtext-inline' : 'js-richtext' }}" rows="{{ $type === 'richtext-inline' ? 4 : 6 }}"
                                  name="blocks[{{ $key }}]">{{ old('blocks.' . $key, $val) }}</textarea>
                    @elseif($type === 'textarea')
                        <textarea class="form-control" rows="3"
                                  name="blocks[{{ $key }}]"
                                  placeholder="{{ $def['default'] ?? '' }}">{{ old('blocks.' . $key, $val) }}</textarea>
                    @else
                        <input type="text" class="form-control"
                               name="blocks[{{ $key }}]"
                               value="{{ old('blocks.' . $key, $val) }}"
                               placeholder="{{ $def['default'] ?? '' }}">
                    @endif

                    @if($isTranslating)
                        @if($source)
                        <div class="form-text border-start border-3 ps-2 mt-1" style="border-color:#f0ad4e !important;">
                            <span class="text-muted">{{ $defaultLocaleName }}原文：</span>{{ \Illuminate\Support\Str::limit(trim(strip_tags($source)), 200) }}
                        </div>
                        @endif
                    @elseif(!empty($def['default']))
                        <div class="form-text">預設：<code>{{ \Illuminate\Support\Str::limit($def['default'], 120) }}</code></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

    <div class="mb-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <svg class="icon me-2"><use xlink:href="/assets/icons/free.svg#cil-save"></use></svg>
            儲存（{{ $locale }}）
        </button>
        @if($previewUrl)
        <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="btn btn-outline-secondary">前台預覽</a>
        @endif
        <a href="{{ route('admin.content.index') }}" class="btn btn-light">返回</a>
    </div>
</form>

@php
    $hasRichtext = collect($grouped)
        ->flatMap(fn ($items) => collect($items)->pluck('type'))
        ->contains(fn ($t) => str_starts_with((string) $t, 'richtext'));
@endphp
@if($hasRichtext)
    @include('admin.partials.richtext-editor')
@endif
@endsection
